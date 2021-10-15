<?php

namespace App\Observers;

use App\Models\Clients;

class ClientObserver
{
    /**
     * Handle the Clients "created" event.
     *
     * @param \App\Models\Clients $clients
     * @return void
     */
    public function created(Clients $clients)
    {
        //
    }

    /**
     * Handle the Clients "updated" event.
     *
     * @param \App\Models\Clients $clients
     * @return void
     */
    public function updated(Clients $clients)
    {
        //
    }

    /**
     * Handle the Clients "deleted" event.
     *
     * @param \App\Models\Clients $clients
     * @return void
     */
    public function deleted(Clients $clients)
    {
        //
    }

    /**
     * Handle the Clients "restored" event.
     *
     * @param \App\Models\Clients $clients
     * @return void
     */
    public function restored(Clients $clients)
    {
        //
    }

    /**
     * Handle the Clients "force deleted" event.
     *
     * @param \App\Models\Clients $clients
     * @return void
     */
    public function forceDeleted(Clients $clients)
    {
        //
    }
}
