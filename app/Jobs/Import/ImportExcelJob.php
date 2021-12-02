<?php

namespace App\Jobs\Import;

use App\Actions\Excel\Import\ImportContratosAssinadosExcel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;

class ImportExcelJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $company, $type;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($type, $company)
    {
        $this->type = $type;
        $this->company = $company;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->type == 'ContratosAssinados') {
            return Excel::toArray(new ImportContratosAssinadosExcel(), $this->company->getMedia($this->type));
        } else {
            return false;
        }
    }
}
