<?php

namespace App\Observers;

use App\Models\ClientStatus;

class ClientStatusObserver
{
    /**
     * Handle the ClientStatus "created" event.
     *
     * @param \App\Models\ClientStatus $clientStatus
     * @return void
     */
    public function created(ClientStatus $clientStatus)
    {
        //
    }

    /**
     * Handle the ClientStatus "updated" event.
     *
     * @param \App\Models\ClientStatus $clientStatus
     * @return void
     */
    public function updated(ClientStatus $clientStatus)
    {
        //
    }

    /**
     * Handle the ClientStatus "deleted" event.
     *
     * @param \App\Models\ClientStatus $clientStatus
     * @return void
     */
    public function deleted(ClientStatus $clientStatus)
    {
        //
    }

    /**
     * Handle the ClientStatus "restored" event.
     *
     * @param \App\Models\ClientStatus $clientStatus
     * @return void
     */
    public function restored(ClientStatus $clientStatus)
    {
        //
    }

    /**
     * Handle the ClientStatus "force deleted" event.
     *
     * @param \App\Models\ClientStatus $clientStatus
     * @return void
     */
    public function forceDeleted(ClientStatus $clientStatus)
    {
        //
    }
}
