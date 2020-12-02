<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailVerification extends Mailable
{
    use Queueable, SerializesModels;

    public $emailVerifyCode;

    /**
     * Create a new message instance.
     *
     * @param $emailVerifyCode
     */
    public function __construct($emailVerifyCode)
    {
        $this->emailVerifyCode = $emailVerifyCode;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('user.emailVerifyMessage', ['emailVerifyCode' => $this->emailVerifyCode]);
    }
}
