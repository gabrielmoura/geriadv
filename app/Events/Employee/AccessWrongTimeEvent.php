<?php

namespace App\Events\Employee;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
/**
 *  Disparar evento quando usuário acessar no horário errado.
 */
class AccessWrongTimeEvent
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
