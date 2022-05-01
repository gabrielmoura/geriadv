<?php

namespace App\Http\Controllers\Import;

use App\Http\Controllers\Controller;
use App\Models\Benefits;
use App\Models\Clients;
use App\Models\Note;
use App\Models\Recommendation;
use Illuminate\Http\Request;
use Illuminate\Support\LazyCollection;

class ImportCCAController extends Controller
{
    public function store(Request $request)
    {
        //https://josephsilber.com/posts/2020/07/29/lazy-collections-in-laravel
//        $request->validate([
//            'file' => 'required:mimes:csv,txt'
//        ]);
        //$file = $request->file('file')->store('tmp');
        //$companyId=$request->company_id;
        $companyId = 1;
        $file = storage_path('app/PLANILHA_GERAL_CONTRATOS_ASSINADOS_CENTRO.csv');

        $collect = LazyCollection::make(function () use ($file) {
            $handle = fopen($file, 'r');
            while (($line = fgets($handle)) !== false) {
                yield str_getcsv($line, ';');
            }
        });
//        $collect->each(function (array $item) {
//
//        });
//        $times = 100;
//        foreach ($collect->chunk($times) as $row) {
//            dump($row);
//        }
        $times = 100;
        foreach ($collect->chunk($times) as $item) {
            foreach ($item as $row) {
                $benefit = (isset($row[4])) ? Benefits::firstOrNew(['name' => $row[4]]) : null;
                $recommendation = (isset($row[5])) ? Recommendation::firstOrNew(['name' => $row[5]]) : null;
                $client = Clients::create([
                    'name' => explode(' ', $row[1])[0]
                    , 'last_name' => str_replace(explode(' ', $row[1])[0], "", $row[1])
                    , 'tel0' => numberClear(explode('/', (isset($row[2])) ? $row[2] : null)[0] ?? null) ?? null
                    , 'tel1' => numberClear(explode('/', (isset($row[2])) ? $row[2] : null)[1] ?? null) ?? null
                    , 'cpf' => numberClear($row[7] ?? null) ?? 999
                    , 'email' => $row[10] ?? null
                    , 'number' => 999
                    , 'district' => $row[3] ?? ' '
                    , 'city' => 'null'
                    , 'state' => 'Rio de Janeiro'
                    , 'recommendation_id' => $recommendation->id ?? null
                    , 'benefit_id' => $benefit->id ?? null
                    , 'company_id' => $companyId
                ]);
                Note::create(['body' => $row[6] ?? 'Importado Automaticamente', 'client_id' => $client->id ?? null]);
            }
        }

    }

    private function getRow($row)
    {
        if (isset($row)) {
            return $row;
        }
        return null ?? 999;
    }

    private function firstName($row)
    {
        if (isset($row)) {
            return explode(' ', $row)[0];
        }
        return ' ' ?? null;
    }

    private function lastName($row)
    {
        if (isset($row)) {
            return str_replace($this->firstName($row), "", $row);
        }
        return ' ' ?? null;
    }
}
