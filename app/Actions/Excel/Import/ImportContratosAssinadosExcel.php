<?php

namespace App\Actions\Excel\Import;

use App\Jobs\Import\ArrayToDBJob;
use App\Models\Clients;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

use Maatwebsite\Excel\Concerns\RemembersChunkOffset;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;

//use Maatwebsite\Excel\Concerns\WithHeadingRow;

//use Maatwebsite\Excel\Concerns\ToCollection;
class ImportContratosAssinadosExcel implements WithBatchInserts, WithChunkReading
{
    use RemembersRowNumber, RemembersChunkOffset;
    protected $companyId;

    //  protected $data = ["DATA", "NOME ", "TELEFONE", "BAIRRO", "BENEFICIO", "INDICA\u00c7\u00c3O", "PEND\u00caNCIA DE DOCUMENTOS", "OUTRAS PENDENCIAS", "OBSERVA\u00c7\u00c3O", "ENVIADOS", "ENTRADA", "CPF", "SENHA", "SITUA\u00c7\u00c3O", "NOVA ENTRADA", "DATA DE PESQUISA", "ADV", "PAGAMENTO", "EMAIL"];
//0DATA	1NOME 	2TELEFONE	3BAIRRO	4BENEFICIO	5INDICAÇÃO	6PENDÊNCIA DE DOCUMENTOS 	7OUTRAS PENDENCIAS	8OBSERVAÇÃO	9ENVIADOS	10ENTRADA	11CPF	12SENHA	13SITUAÇÃO	14NOVA ENTRADA	15DATA DE PESQUISA	16ADV	17PAGAMENTO	18EMAIL	12Avaliação/ Pericia

    public function __construct($companyId)
    {
        //parent::__construct();
        ini_set('memory_limit', '-1');
        $this->companyId = $companyId;

    }

    public function collection(Collection $rows)
    {

        Storage::disk('temp')->put('contratosAssinados.json', $rows);


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
