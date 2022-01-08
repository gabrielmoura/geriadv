<?php

namespace App\Jobs;

use App\Models\Clients;
use App\Models\Company;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * Limpa SoftDeletes maiores que um tempo determinado.
 * Class ClearSoftDeletionsjob
 * @package App\Jobs
 */
class ClearSoftDeletionsjob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->searchDelete(Clients::all());
        $this->searchDelete(Company::all());
    }


    protected function searchDelete($all)
    {
        foreach ($all as $item) {
            if ($item->deleted_at->gt(now())) {
                $item->forceDelete();
            }
        }
    }
}
