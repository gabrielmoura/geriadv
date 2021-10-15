<?php

namespace App\Listeners\Client;

use App\Models\User;
use App\Notifications\Client\BirthdayCustomerNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class BirthdayCustomerListener implements ShouldQueue
{

    /**
     * The name of the queue the job should be sent to.
     *
     * @var string|null
     */
    public $queue = 'listeners';

    /**
     * The time (seconds) before the job should be processed.
     *
     * @var int
     */
    public $delay = 60;

    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle($event)
    {
        $admins = User::role('manager')->get();
        Notification::send($admins, new BirthdayCustomerNotification($event));
    }
}
