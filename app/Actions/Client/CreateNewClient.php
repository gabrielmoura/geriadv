<?php


namespace App\Actions\Client;


use App\Models\Clients;
use App\Models\LogMovement;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class CreateNewClient
{
    public function __construct(Request $input)
    {
        $input->validate([


            /**
             * Dados Pessoais
             */
            'name' => 'required|min:3'
            , 'last_name' => 'required|min:3'
            , 'tel' => 'required'
            , 'rg' => 'required'
            , 'cpf' => 'required|cpf_cnpj'
            , 'sex' => 'required'
            , 'birth_date' => 'required|date'

            /**
             * Dados do Endereço
             */
            , 'cep' => 'required'
            , 'address' => 'required'
            , 'number' => 'required|numeric'
            , 'complement' => 'required'
            , 'district' => 'required'
            , 'city' => 'required'
            , 'state' => 'required'
            , 'country'
            , 'newsletter'
        ]);


        //Caso ocorra qualquer erro ele desfará toda a operação.
        return DB::transaction(function () use ($input) {


            $client = Clients::create([

                /**
                 * Dados Pessoais
                 */
                'name' => $input['name']
                , 'last_name' => $input['last_name']
                , 'tel0' => preg_replace('/[^0-9]/', '', $input['tel'])
                , 'doc' => Crypt::encryptString($input['cpf'])
                , 'sex' => $input['sex']
                , 'birth_date' => $input['birth_date']

                /**
                 * Dados do Endereço
                 */
                , 'cep' => preg_replace('/[^0-9]/', '', $input['cep'])
                , 'address' => $input['address']
                , 'number' => $input['number']
                , 'complement' => $input['complement']
                , 'district' => $input['district']
                , 'city' => $input['city']
                , 'state' => $input['state']
                //, 'country' => $input['country']
                // , 'newsletter' => $input['newsletter']
            ]);
            Note::create(['user_id' => $client->id, 'body' => $input['note']]);
            LogMovement::create([
                'body' => 'Adicionou o cliente ' . $client->name . ' ' . $client->last_name,
                'user_id' => auth()->id]);
            return $client;
        });

    }
}
