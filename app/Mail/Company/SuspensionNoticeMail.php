<?php

namespace App\Mail\Client;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SuspensionNoticeMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $title, $body;


    public function __construct($body, $title = null)
    {
        $this->title = config('app.name', $title);
        $this->body = $body;


    }


    public function build()
    {
        $body = $this->body;
        $title = $this->title;
        return $this->subject($this->title)
            ->view('mail.company.suspensionNotice', compact('body', 'title'));

    }
}
