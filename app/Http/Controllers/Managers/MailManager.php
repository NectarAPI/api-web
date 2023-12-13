<?php

namespace App\Http\Controllers\Managers;

use App\Mail\WelcomeMail;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Mail;

class MailManager {
    
    public function sendWelcomeEmail(string $name, string $email, 
                                    string $emailConfirmIdentifier) {
        $data = ([
            'name' => $name,
            'email' => $email,
            'confirm_identifier' => $emailConfirmIdentifier
        ]);
        
        Mail::to($email)->send(new WelcomeMail($data));
    }

    public function sendResetPasswordEmail(string $name, string $email, 
                                            string $emailConfirmIdentifier) {
        $data = ([
                    'name' => $name,
                    'email' => $email,
                    'confirm_identifier' => $emailConfirmIdentifier
                ]);
                                                
        Mail::to($email)->send(new ResetPasswordMail($data));
    }
}