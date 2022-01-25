<?php

namespace App\Notifications\User;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PrivateMessageNotification extends Notification
{
    use Queueable;

    protected $title, $body, $action_url, $from;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($title, $body, $action_url, $from)
    {
        $this->title = $title;
        $this->body = $body;
        $this->action_url = $action_url;
        $this->from = $from;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }



    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'title' => $this->title,
            'body' => $this->body,
            'action_url' => $this->action_url,
            'from' => $this->from
        ];
    }
}
