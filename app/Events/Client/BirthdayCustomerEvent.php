<?php

namespace App\Events\Client;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BirthdayCustomerEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $invoke;

    public function __construct($invoke)
    {
        $this->invoke = $invoke;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel(config('app.name') . 'BirthdayCustomer');
    }
}
