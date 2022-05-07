<?php

namespace App\Mail\Company;

use App\Models\Company;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


use Illuminate\Support\Facades\Password;

class WelcomeCompanyMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * @var
     */
    /**
     * @var
     */
    protected $company_id, $user;


    /**
     * @param $company_id
     * @param $user
     */
    public function __construct($company_id, $user)
    {
        $this->company_id = $company_id;
        $this->user = $user;
        $this->afterCommit();
    }


    /**
     * @return WelcomeCompanyMail
     */
    public function build()
    {
        $token = Password::createToken($this->user);
        $urlReset = route('password.reset', ['token' => $token]);
        $c = Company::find($this->company_id);
        return $this->markdown('emails.company.welcome', ['company' => $c, 'urlReset' => $urlReset])->onQueue('high')->subject('Email de Boas Vindas');
    }
}
