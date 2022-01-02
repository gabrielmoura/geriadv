<?php

namespace App\Jobs\Company;

use App\Events\Company\DeleteCompanyEvent;
use App\Models\Company;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeleteCompanyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Company
     */
    protected $company;


    /**
     * DeleteCompanyJob constructor.
     * @param Company $company
     */
    public function __construct(Company $company)
    {
        $this->company = $company;
    }


    public function handle()
    {

        // Deleta os clientes;
        foreach ($this->company->clients()->get() as $client) {
            $client->delete(); //softDelete
        }
        // Deleta os funcionários e suas contas;
        foreach ($this->company->employees()->get() as $employee) {
            $employee->forceDelete();
            $employee->user()->first()->delete();
        }
        // Deleta a empresa;
        $this->company->delete(); //softDelete

        // Dispara evento que a empresa foi deletada do Banco de Dados;
        event(new DeleteCompanyEvent($this->company));
    }
}
