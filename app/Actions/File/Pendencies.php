<?php


namespace App\Actions\File;


use App\Models\Clients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Controle de Pendencias
 * Class Pendencies
 * @package App\Actions\File
 */
class Pendencies
{
    public function upload(Request $request, $client_id)
    {
        $client = Clients::find($client_id);

        if ($request->cras)
            $this->toDOC($client, $request->cras, 'cras');
        //$client->addMedia()->toMediaCollection('cras');

        if ($request->cpf)
            $this->toDOC($client, $request->cpf, 'cpf');
        //$client->addMedia($request->cpf)->toMediaCollection('cpf');

        if ($request->rj)
            $this->toDOC($client, $request->rj, 'rj');
        //$client->addMedia($request->rj)->toMediaCollection('rj');

        if ($request->birth_certificate)
            $this->toDOC($client, $request->birth_certificate, 'birth_certificate');
        //$client->addMedia($request->birth_certificate)->toMediaCollection('birth_certificate');

        if ($request->proof_of_address)
            $this->toDOC($client, $request->proof_of_address, 'proof_of_address');
        //$client->addMedia($request->proof_of_address)->toMediaCollection('proof_of_address');

    }

    private function toDOC($client, $file, $name)
    {
        DB::transaction(function () use ($client, $file, $name) {
            $client->addMedia($file)->toMediaCollection($name);
        });
    }

}
