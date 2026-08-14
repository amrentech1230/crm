<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Mail\Message;

class MailController extends Controller
{
    public function send(Request $request)
    {
		
        $email = $request->input('email');
		$ccemail = $request->input('ccemail');
        $files = $request->input('documents', []); 
        $load_no = $request->input('load_no');
        $refrance_no = $request->input('refrance_no');
        $invoice_no = $request->input('invoice_no');
        $cf = $request->input('customer_refrence_number');
        $username = Auth::user()->name;
		
		$emailArray = array_map('trim', explode(',', $email));
		$ccArray = array_map('trim', explode(',', $ccemail));

        try {
            Mail::mailer('smtp')->raw('', function (Message $message) use ($emailArray, $ccArray, $username, $load_no, $refrance_no, $invoice_no, $files, $cf) {
                $htmlBody = 'Greetings!<br><p>Kindly find the attached invoice for load #'.$load_no.'('.$invoice_no.') Ref #'.$refrance_no.'</p><br><p>Thanks & Regards</p><p>'.$username.'</p><p>Accounts Receivable</p><p>Cargo Convoy Inc</p><p>Mailing Address : 7119, Pennsylvania Ave, Upper Darby, PA - 19082</p><p>Physical Address : Rosemont Business Campus - 9919 Conestoga Road Bldg. 3 Suite 215 Bryn Mawr, PA 19010</p><p>MC - 01512751 | DOT - 4014885</p>';
                
                $message->to($emailArray)
                        ->from('ar@cargoconvoy.co', 'Cargoconvoy')
                        ->replyTo('ar@cargoconvoy.co')
                        ->subject('Invoice For Load #'.$load_no.' (#'.$invoice_no.') REF #'.$refrance_no.' / '.$cf)
                        ->html($htmlBody); 
				
				if (!empty(array_filter($ccArray))) {
					$message->cc($ccArray);
				}
                        
                // Attach files
                foreach ($files as $file) {
                    $filePath = public_path($file);
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
            return response()->json(['success' => true, 'message' => 'Email sent with ' . count($files) . ' attachment(s).']);
           
        } catch (\Exception $e) {
            \Log::error('Mail sending failed: ' . $e->getMessage());
           return response()->json(['error' => false, 'message' => $e->getMessage()], 404);
        }
    }
}