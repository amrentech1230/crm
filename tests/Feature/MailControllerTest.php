<?php

namespace Tests\Feature;

use App\Http\Controllers\MailController;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Tests\TestCase;

class MailControllerTest extends TestCase
{
    public function test_send_uses_the_request_subject_for_invoice_email(): void
    {
        $controller = new MailController();
        $request = new Request([
            'subject' => 'Invoice subject from modal',
        ]);

        $reflection = new \ReflectionClass($controller);
        $method = $reflection->getMethod('resolveEmailSubject');
        $method->setAccessible(true);

        $subject = $method->invokeArgs($controller, [$request, 'LOAD123', 'INV1', 'REF1']);

        $this->assertSame('Invoice subject from modal', $subject);
    }

    public function test_prepare_attachments_falls_back_to_individual_attachments_when_merge_is_unavailable(): void
    {
        putenv('PATH=' . sys_get_temp_dir());

        $controller = new MailController();
        $reflection = new \ReflectionClass($controller);
        $method = $reflection->getMethod('prepareAttachments');
        $method->setAccessible(true);

        $folder = 'uploads/delivery-order/mail-controller-test-' . uniqid('', true);
        $folderPath = public_path($folder);
        if (!is_dir($folderPath)) {
            mkdir($folderPath, 0755, true);
        }

        $firstPdf = $folderPath . '/first.pdf';
        $secondPdf = $folderPath . '/second.pdf';

        $this->createPdf($firstPdf, 'First document');
        $this->createPdf($secondPdf, 'Second document');

        $files = [$folder . '/first.pdf', $folder . '/second.pdf'];

        [$attachmentPaths, $temporaryFiles] = $method->invokeArgs($controller, [$files, '12345']);

        $this->assertCount(1, $attachmentPaths);
        $this->assertFileExists($attachmentPaths[0]);
        $this->assertGreaterThan(0, filesize($attachmentPaths[0]));

        foreach ($temporaryFiles as $temporaryFile) {
            if (is_file($temporaryFile)) {
                @unlink($temporaryFile);
            }
        }

        foreach (glob($folderPath . '/*') as $file) {
            @unlink($file);
        }

        @rmdir($folderPath);
    }

    private function createPdf(string $path, string $content): void
    {
        $dompdf = new Dompdf();
        $dompdf->loadHtml('<html><body><p>' . htmlspecialchars($content, ENT_QUOTES, 'UTF-8') . '</p></body></html>');
        $dompdf->setPaper('a4', 'portrait');
        $dompdf->render();

        file_put_contents($path, $dompdf->output());
    }
}
