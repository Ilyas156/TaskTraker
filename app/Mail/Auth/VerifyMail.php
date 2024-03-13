<?php

namespace App\Mail\Auth;

use App\Entity\User\User;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

final class VerifyMail extends Mailable
{
    use SerializesModels;

    public function __construct(
        public User $user
    ) {
    }

    public function build(): VerifyMail
    {
        return $this
            ->subject('Signup Confirmation')
            ->markdown('emails.auth.register.verify');
    }
}

