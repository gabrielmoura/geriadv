<?php

namespace App\Jobs\Import;

use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\LazyCollection;

class ImportExcelCAJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    /**
     * @var
     */
    /**
     * @var
     */
    /**
     * @var int
     */
    public $path, $company_id, $backoff = 3;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($path, $company_id)
    {
        $this->company_id = $company_id;
        $this->path = $path;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (optional($this->batch())->canceled()) {
            // optionally perform some clean up if necessary
            return;
        }
        $company_id = $this->company_id;
        $times = 20;

        $collect = LazyCollection::make(function () {
            $handle = fopen($this->path, 'r');
            while (($line = fgets($handle)) !== false) {
                yield str_getcsv($line, ';');
            }
        })->filter()->chunk($times);

        //      Adiciona novos trabalhos ao Lote
        foreach ($collect as $item) {
            $this->batch()->add(new ImportCSVJob($item, $company_id));
            usleep(100000); //0.1Second
        }
    }

}
