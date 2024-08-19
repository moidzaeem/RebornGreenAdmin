<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $message;

    public function __construct($subject, $message)
    {
        $this->subject = $subject;
        $this->message = $message;
    }

    public function build()
    {
        $data['message']=$this->message;
        return $this->subject($this->subject)
            ->view('emails.custom')
            ->with([
                'subject' => $this->subject,
                'data' => $data,
            ]);
    }
}
