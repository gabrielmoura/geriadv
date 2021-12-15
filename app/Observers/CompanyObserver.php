<?php

namespace App\Observers;

use App\Models\Company;

class CompanyObserver
{
    /**
     * Handle the Company "created" event.
     *
     * @param \App\Models\Clients $companies
     * @return void
     */
    public function created(Company $companies)
    {
        //
    }

    /**
     * Handle the Company "updated" event.
     *
     * @param \App\Models\Company $companies
     * @return void
     */
    public function updated(Company $companies)
    {
        //
    }

    /**
     * Handle the Company "deleted" event.
     *
     * @param \App\Models\Company $companies
     * @return void
     */
    public function deleted(Company $companies)
    {
        foreach($companies->employees()->get() as $employee){
            $employee->delete();
        }
    }

    /**
     * Handle the Company "restored" event.
     *
     * @param \App\Models\Company $companies
     * @return void
     */
    public function restored(Company $companies)
    {
        //
    }

    /**
     * Handle the Company "force deleted" event.
     *
     * @param \App\Models\Company $clients
     * @return void
     */
    public function forceDeleted(Company $companies)
    {
        //
    }
}
