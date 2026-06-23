<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MultipleAttachmentMail extends Mailable
{
    use Queueable, SerializesModels;

    public $files;

    public function __construct($files)
    {
        $this->files = $files;
    }

    public function build()
    {
        $email = $this->subject('Your Requested Documents')
                      ->view('emails.multiple-attachments');

        foreach ($this->files as $file) {
            $email->attach(public_path($file));
        }

        return $email;
    }
}

