<?php

namespace App\Jobs\Import;

use App\Models\Benefits;
use App\Models\Clients;
use App\Models\Note;
use App\Models\Recommendation;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportCSVJob implements ShouldQueue
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
    public $data, $company_id, $backoff = 3;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data, $company_id)
    {
        $this->company_id = $company_id;
        $this->data = $data;
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
        foreach ($this->data as $row) {
            //  https://josephsilber.com/posts/2020/07/29/lazy-collections-in-laravel
            //  https://laravel-news.com/firstornew-firstorcreate-firstor-updateorcreate
            //  https://freek.dev/1734-how-to-group-queued-jobs-using-laravel-8s-new-batch-class
            $benefit = $this->newBenefit($row, $this->company_id);
            $recommendation = $this->newRecommendation($row);
            $client = Clients::create([
                'name' => $this->firstName($row[1])
                , 'last_name' => $this->lastName($row[1])
                , 'tel0' => $this->getTel($row)[0]
                , 'tel1' => $this->getTel($row)[1]
                , 'cpf' => numberClear($row[7] ?? null) ?? 999
                , 'email' => $row[10] ?? null
                , 'number' => 999
                , 'district' => $row[3] ?? ' '
                , 'city' => 'null'
                , 'state' => 'Rio de Janeiro'
                , 'recommendation_id' => $recommendation ?? null
                , 'benefit_id' => $benefit ?? null
                , 'company_id' => $this->company_id
            ]);
            Note::create(['body' => $row[6] ?? 'Importado Automaticamente', 'client_id' => $client->id ?? null]);
        }
    }

    /**
     * @param $row
     * @param $company_id
     * @return int|mixed|null
     */
    private function newBenefit($row, $company_id)
    {
        if (isset($row[4])) {
            $x = Benefits::firstOrCreate(['name' => $row[4], 'company_id' => $company_id]);
        }
        return $x->id ?? null;
    }

    /**
     * @param $row
     * @return int|mixed|null
     */
    private function newRecommendation($row)
    {
        if (isset($row[5])) {
            $x = Recommendation::firstOrCreate(['name' => $row[5]]);
        }
        return $x->id ?? null;
    }

    /**
     * @param $row
     * @return int
     */
    private function getRow($row)
    {
        if (isset($row)) {
            return $row;
        }
        return null ?? 999;
    }

    /**
     * @param $row
     * @return string|null
     */
    private function firstName($row)
    {
        if (isset($row)) {
            return explode(' ', $row)[0];
        }
        return ' ' ?? null;
    }

    /**
     * @param $row
     * @return array|string|string[]|null
     */
    private function lastName($row)
    {
        if (isset($row)) {
            return str_replace($this->firstName($row), "", $row);
        }
        return ' ' ?? null;
    }

    /**
     * @param $row
     * @return string[]|null
     */
    private function getTel($row)
    {
        if (isset($row[2])) {
            $line = $row[2];
            $tel0 = null;
            $tel1 = null;
            $explode = explode('/', $line);

            if (array_key_exists(0, $explode)) {
                $tel0 = $explode[0];
            }
            if (array_key_exists(1, $explode)) {
                $tel1 = $explode[1];
            }

            return [numberClear($tel0), numberClear($tel1)];
        }
        return null;
    }
}
