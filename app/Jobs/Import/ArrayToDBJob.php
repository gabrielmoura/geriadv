<?php


namespace App\Jobs\Import;

use App\Actions\Excel\Import\ImportContratosAssinadosExcel;
use App\Models\Clients;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Collection;

class ArrayToDBJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $company, $collect;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Collection $collect, $company)
    {
        $this->collect = $collect;
        $this->company = $company;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->collect as $row) {


                Clients::create([
                    'name' => $this->cleanName($row[1])[0]
                    , 'last_name' => $this->cleanName($row[1])[1]
                    , 'tel0' => numberClear($row[2])
                    , 'cpf' => $row[10]
                    , 'rg' => null
                    , 'sex' => null
                    , 'birth_date' => null
                    , 'email' => $row[18]

                    /**
                     * Dados do Endereço
                     */
                    , 'cep' => $this->numberClear($this->faker->postcode())
                    , 'address' => $this->faker->address()
                    , 'number' => $this->faker->randomNumber()
                    , 'complement' => collect(range('A', 'Z'))->random()

                    , 'district' => $row[3]
                    , 'city' => $this->faker->city()
                    , 'state' => $this->faker->stateAbbr()

                    //, 'country'
                    //, 'newsletter'

                    //, 'recommendation_id'

                    , 'benefit_id' => row[4]
                    , 'company_id' => $this->companyId
                ]);

        }
    }
    private function cleanName($var)
    {
        $array = explode(' ', $var);
        $last_name = str_replace($array[0], '', $var);
        return [$array[0], $last_name];
    }
}
