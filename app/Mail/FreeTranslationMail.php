<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FreeTranslationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $email;
    public $mobile;
    public $file;

    public function __construct($name, $email, $mobile, $file)
    {
        $this->name = $name;
        $this->email = $email;
        $this->mobile = $mobile;
        $this->file = $file;
    }

    public function build()
    {
        return $this->subject('New Free Translation Request')
            ->view('emails.free_translation')
            ->attach($this->file->getRealPath(), [
                'as' => $this->file->getClientOriginalName(),
                'mime' => $this->file->getMimeType(),
            ]);
    }
}
