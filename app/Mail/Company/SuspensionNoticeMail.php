<?php

namespace App\Mail\Company;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SuspensionNoticeMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $data;


    public function __construct($data)
    {
        $this->data = $data;


    }


    public function build()
    {
        $body = $this->data['body'];
        $title = $this->data['title'];
        return $this->subject($title)
            ->view('mail.company.suspensionNotice', compact('body', 'title'));

    }
}
