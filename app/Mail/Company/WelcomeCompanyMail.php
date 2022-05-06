<?php

namespace App\Mail\Company;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use Illuminate\Support\Facades\Password;

class WelcomeCompanyMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $company, $user;


    public function __construct($company, $user)
    {
        $this->company = $company;
        $this->user = $user;
    }


    public function build()
    {
        $token = Password::createToken($this->user);
        $urlReset = route('password.reset', ['token' => $token]);
        return $this->markdown('emails.company.welcome', ['company' => $this->company, 'urlReset' => $urlReset])->onQueue('high');
    }
}
