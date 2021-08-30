<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Controller;
use App\Models\Clients;
use App\Models\LogMovement;
use App\Models\Note;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Clients::all();
        return view('admin.client.index', compact('clients'));
    }

    public function show($slug)
    {
        $client = Clients::whereSlug($slug)->first();

        return view('admin.client.show', compact('client'));
    }

    public function create()
    {
        $clients = Clients::all();
        $form = ['route' => ['admin.clients.store'], 'method' => 'post'];
        return view('admin.client.form', compact('clients', 'form'));
    }

    public function store(Request $request)
    {

        //$client = new CreateNewClient($request);

        $request->validate([
            /**
             * Dados Pessoais
             */
            'name' => 'required|min:3'
            , 'last_name' => 'required|min:3'
            , 'tel0' => 'required'
            , 'rg' => ''
            , 'cpf' => 'required|cpf_cnpj|unique:clients'
            , 'sex' => 'required'
            , 'birth_date' => 'required|date'

            /**
             * Dados do Endereço
             */
            , 'cep' => 'required'
            , 'address' => 'required'
            , 'number' => 'required|numeric'
            , 'complement' => ''
            , 'district' => 'required'
            , 'city' => 'required'
            , 'state' => 'required'
            , 'country'
            , 'newsletter'
        ]);

        $client = DB::transaction(function () use ($request) {

            $client = Clients::create([

                /**
                 * Dados Pessoais
                 */
                'name' => $request['name']
                , 'last_name' => $request['last_name']
                , 'tel0' => preg_replace('/[^0-9]/', '', $request['tel0'])
                , 'cpf' => $request['cpf']
                , 'sex' => $request['sex']
                , 'birth_date' => Carbon::make($request['birth_date'])

                /**
                 * Dados do Endereço
                 */
                , 'cep' => preg_replace('/[^0-9]/', '', $request['cep'])
                , 'address' => $request['address']
                , 'number' => $request['number']
                , 'complement' => $request['complement']
                , 'district' => $request['district']
                , 'city' => $request['city']
                , 'state' => $request['state']
                //, 'country' => $input['country']
                // , 'newsletter' => $input['newsletter']
            ]);
            Note::create(['user_id' => $client->id, 'body' => $request['note']]);
            LogMovement::create([
                'body' => 'Adicionou o cliente ' . $client->name . ' ' . $client->last_name,
                'user_id' => auth()->id()]);
            return $client;
        });

        toastr()->success('Cliente:' . $client->name . ' criado com sucesso', 'Client');
        return redirect()->route('admin.clients.index');
    }

    public function edit($slug)
    {
        $clients = Clients::whereSlug($slug)->first();
        $form = ['route' => ['admin.client.update', $slug], 'method' => 'put'];
        return view('admin.client.form', compact('clients', 'form'));
    }

    public function update(Request $request, $slug)
    {
        $data = $request->all();

        $client = DB::transaction(function () use ($data, $slug) {
            $client = Clients::whereSlug($slug)->first();
            $client->update($data);
            LogMovement::create([
                'body' => 'Atualizou o cliente ' . $client->name . ' ' . $client->last_name,
                'user_id' => auth()->id]);
            return $client;
        });
        return redirect()->route('admin.client.index')->with('success', 'Cliente:' . $client->name . ' atualizado com sucesso');
    }

    public function delete($slug)
    {
        Clients::whereSlug($slug)->delete();
    }
}
