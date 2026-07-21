<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Mail\Message;
use Symfony\Component\Process\Process;
use Dompdf\Dompdf;

class MailController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string'],
            'documents' => ['nullable', 'array'],
            'documents.*' => ['string'],
        ]);

		$email = $request->input('email');
		$ccemail = $request->input('ccemail');
        $files = $request->input('documents', []);
        $load_no = $request->input('load_no');
        $refrance_no = $request->input('refrance_no');
        $invoice_no = $request->input('invoice_no');
        $username = Auth::user()->name;
		
		$emailArray = array_filter(array_map('trim', explode(',', $email)));
		$ccArray = array_filter(array_map('trim', explode(',', (string) $ccemail)));
        $temporaryFiles = [];

        try {
            [$attachmentPaths, $temporaryFiles] = $this->prepareAttachments($files, $load_no);

            Mail::mailer('smtp')->raw('', function (Message $message) use ($emailArray, $ccArray, $username, $load_no, $refrance_no, $invoice_no, $attachmentPaths) {
                $htmlBody = 'Greetings!<br><p>Kindly find the attached invoice for load #'.$load_no.'('.$invoice_no.') Ref #'.$refrance_no.'</p><br><p>Thanks & Regards</p><p>'.$username.'</p><p>Accounts Receivable</p><p>Cargo Convoy Inc</p><p>Mailing Address : 7119, Pennsylvania Ave, Upper Darby, PA - 19082</p><p>Physical Address : Rosemont Business Campus - 9919 Conestoga Road Bldg. 3 Suite 215 Bryn Mawr, PA 19010</p><p>MC - 01512751 | DOT - 4014885</p>';
                
                $message->to($emailArray)
                        ->from('ar@cargoconvoy.co', 'Cargoconvoy')
                        ->replyTo('ar@cargoconvoy.co')
                        ->subject('Invoice For Load #'.$load_no.' (#'.$invoice_no.') REF #'.$refrance_no)
                        ->html($htmlBody); 
				
				if (!empty(array_filter($ccArray))) {
					$message->cc($ccArray);
				}
                        
                foreach ($attachmentPaths as $filePath) {
                    if (file_exists($filePath) && is_readable($filePath)) {
                        $message->attach($filePath, [
                            'as' => basename($filePath),
                            'mime' => mime_content_type($filePath)
                        ]);
                    } else {
                        \Log::error("Attachment failed: " . $filePath);
                    }
                }
            });
			$subject = 'mail send to customer cutomername:- '.implode(", ", $emailArray);
			
            addToLog($customerId ='', $load_no, $subject, $oldData ='', $newData ='');
            return response()->json(['success' => true, 'message' => 'Email sent with ' . count($attachmentPaths) . ' attachment(s).']);
           
        } catch (\Exception $e) {
            \Log::error('Mail sending failed: ' . $e->getMessage());
           return response()->json(['error' => false, 'message' => $e->getMessage()], 422);
        } finally {
            foreach ($temporaryFiles as $temporaryFile) {
                if (is_file($temporaryFile)) {
                    @unlink($temporaryFile);
                }
            }
        }
    }

    /**
     * Resolve selected public delivery documents and merge multiple PDFs into
     * one temporary attachment. Only files from the delivery-document folder
     * may be attached, preventing arbitrary server files from being mailed.
     *
     * @return array{0: array<int, string>, 1: array<int, string>}
     */
    private function prepareAttachments(array $files, $loadNo): array
    {
        $deliveryRoot = realpath(public_path('uploads/delivery-order'));
        $uploadsRoot  = realpath(public_path('uploads'));

        $allowedRoots = array_filter([$deliveryRoot, $uploadsRoot]);

        if (empty($allowedRoots)) {
            throw new \RuntimeException('No delivery documents are available to attach.');
        }

        $paths = [];
        foreach (array_unique($files) as $file) {
            $relativePath = ltrim(str_replace('\\', '/', $file), '/');
            $path = realpath(public_path($relativePath));

            if ($path === false || !is_readable($path)) {
                \Log::warning('Mail attachment skipped (not found): ' . $file);
                continue;
            }

            $allowed = false;
            foreach ($allowedRoots as $root) {
                if (str_starts_with($path, $root . DIRECTORY_SEPARATOR) || str_starts_with($path, $root . '/')) {
                    $allowed = true;
                    break;
                }
            }

            if (!$allowed) {
                \Log::warning('Mail attachment rejected (outside allowed path): ' . $file);
                continue;
            }

            $paths[] = $path;
        }

        if (empty($paths)) {
            return [[], []];
        }

        if (count($paths) <= 1) {
            return [$paths, []];
        }

        $temporaryDirectory = storage_path('app/mail-attachments');
        if (!is_dir($temporaryDirectory) && !mkdir($temporaryDirectory, 0755, true) && !is_dir($temporaryDirectory)) {
            throw new \RuntimeException('Unable to prepare the merged attachment.');
        }

        $temporaryFiles = [];
        $pdfPaths = [];
        foreach ($paths as $path) {
            $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
            if ($extension === 'pdf') {
                $pdfPaths[] = $path;
                continue;
            }

            if (!in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'], true)) {
                throw new \RuntimeException('Only PDF and image documents can be merged into one attachment.');
            }

            $imagePdf = $temporaryDirectory . DIRECTORY_SEPARATOR . 'invoice-load-image-' . uniqid('', true) . '.pdf';
            $this->convertImageToPdf($path, $imagePdf);
            $pdfPaths[] = $imagePdf;
            $temporaryFiles[] = $imagePdf;
        }

        $mergedFile = $temporaryDirectory . DIRECTORY_SEPARATOR . 'invoice-load-' . $loadNo . '-' . uniqid('', true) . '.pdf';
        $process = new Process(array_merge(['pdfunite'], $pdfPaths, [$mergedFile]));
        $process->setTimeout(120);
        $process->run();

        if (!$process->isSuccessful() || !is_file($mergedFile) || filesize($mergedFile) === 0) {
            @unlink($mergedFile);
            foreach ($temporaryFiles as $temporaryFile) {
                @unlink($temporaryFile);
            }
            throw new \RuntimeException('Could not merge the selected documents. Please ensure each PDF is valid and try again.');
        }

        $temporaryFiles[] = $mergedFile;
        return [[$mergedFile], $temporaryFiles];
    }

    private function convertImageToPdf(string $imagePath, string $pdfPath): void
    {
        $mime = mime_content_type($imagePath) ?: 'image/jpeg';
        $image = base64_encode((string) file_get_contents($imagePath));
        $dompdf = new Dompdf();
        $dompdf->loadHtml('<html><body style="margin:0;text-align:center"><img style="max-width:100%;max-height:100%" src="data:' . $mime . ';base64,' . $image . '"></body></html>');
        $dompdf->setPaper('a4', 'portrait');
        $dompdf->render();

        if (file_put_contents($pdfPath, $dompdf->output()) === false) {
            throw new \RuntimeException('Could not convert an image document for merging.');
        }
    }
}
