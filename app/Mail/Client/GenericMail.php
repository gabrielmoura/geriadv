<?php

namespace App\Mail\Client;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
class GenericMail extends Mailable implements ShouldQueue
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
            ->view('mail.genericMail', compact('body', 'title'));

    }
}
