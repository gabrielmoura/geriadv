<?php

namespace App\Actions\Excel\Import;

use App\Models\Clients;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

//use Maatwebsite\Excel\Concerns\RemembersChunkOffset;
//use Maatwebsite\Excel\Concerns\RemembersRowNumber;

//use Maatwebsite\Excel\Concerns\WithHeadingRow;

//use Maatwebsite\Excel\Concerns\ToCollection;
class ImportContratosAssinadosExcel implements ToModel, WithBatchInserts, WithChunkReading
{
    //use RemembersRowNumber, RemembersChunkOffset;

    //  protected $data = ["DATA", "NOME ", "TELEFONE", "BAIRRO", "BENEFICIO", "INDICA\u00c7\u00c3O", "PEND\u00caNCIA DE DOCUMENTOS", "OUTRAS PENDENCIAS", "OBSERVA\u00c7\u00c3O", "ENVIADOS", "ENTRADA", "CPF", "SENHA", "SITUA\u00c7\u00c3O", "NOVA ENTRADA", "DATA DE PESQUISA", "ADV", "PAGAMENTO", "EMAIL"];

    public function collection(Collection $rows)
    {
        Storage::disk('local')->put('contratos.json', $rows);
    }

    public function model(array $row)
    {
        //$currentRowNumber = $this->getRowNumber();
        //$chunkOffset = $this->getChunkOffset();


        return new Clients([

            //'created_at'=>Carbon::make($row[0]),
            'name' => explode(' ', $row[1])[0],
            'last_name' => explode(' ', $row[1])[0],
            'tel0' => $row['TELEFONE'] ?? $row[2],
            'district' => $row['BAIRRO'] ?? $row[3],
            'cpf' => $row['CPF'] ?? $row[11],
            'email' => $row['EMAIL'] ?? $row[17],
        ]);
    }

    public function batchSize(): int
    {
        return 50;
    }

    public function chunkSize(): int
    {
        return 50;
    }
}
