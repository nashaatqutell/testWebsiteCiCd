<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $code;
    public $email;
    public function __construct($code, $email)
    {
        $this->code = $code;
        $this->email = $email;
    }

    public function build(): OtpMail
    {
        return $this->subject('Your OTP Code')
            ->view('dashboard.emails.otp')
            ->with([
                'code' => $this->code,
                'email' => $this->email,
            ]);
    }
}
