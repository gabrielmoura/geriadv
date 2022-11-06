<?php

namespace App\Http\Controllers\Adm;

use App\Actions\Payment\PagHiper\Billets;
use App\DataTables\ClientDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\ClientStoreRequest;
use App\Models\Benefits;
use App\Models\Clients;
use App\Models\Note;
use App\Models\Recommendation;
use App\Traits\CompanySessionTraits;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use Yajra\DataTables\Html\Builder;


class ClientController extends Controller
{
    use CompanySessionTraits;

    /**
     * @param ClientDataTable $dataTable
     * @param Request $request
     * @return mixed
     */
    public function index(ClientDataTable $dataTable, Request $request)
    {
        return $dataTable->render('admin.client.datatable', compact('request'));
    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function show($slug)
    {
        $client = Clients::with(['pendency', 'benefit', 'recommendation', 'status', 'media'])->wherePid($slug)
            ->where('company_id', $this->getCompanyId())
            ->first();
        $pendency = $client->pendency;
        return view('admin.client.show', compact('client', 'pendency'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function create()
    {
        $clients = Clients::where('company_id', $this->getCompanyId())->get();
        $form = ['route' => ['admin.clients.store'], 'method' => 'post'];
        $benefits = [];
        foreach (Benefits::where('company_id', $this->getCompanyId())->get() as $benefit) {
            $benefits[] = ['name' => $benefit->name, 'value' => $benefit->id];
        }
        return view('admin.client.form', compact('clients', 'form', 'benefits'));
    }


    /**
     * @param ClientStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function store(ClientStoreRequest $request)
    {
        //$client = new CreateNewClient($request);

        $client = DB::transaction(function () use ($request) {

            $recommendation = (!is_null($request->recommendation)) ? Recommendation::firstOrCreate(['company_id' => $this->getCompanyId(), 'name' => $request->recommendation]) : null;
            $clientData = [
                /**
                 * Dados Pessoais
                 */
                'name' => $request['name']
                , 'last_name' => $request['last_name']
                , 'tel0' => numberClear($request['tel0'])
                , 'cpf' => numberClear($request['cpf'])
                , 'sex' => $request['sex']
                , 'birth_date' => Carbon::createFromFormat('d/m/Y', $request['birth_date'])

                /**
                 * Dados do Endereço
                 */
                , 'cep' => numberClear($request['cep'])
                , 'address' => $request['address']
                , 'number' => numberClear($request['number'])
                , 'complement' => $request['complement']
                , 'district' => $request['district']
                , 'city' => $request['city']
                , 'state' => $request['state']

                //, 'country' => $input['country']
                // , 'newsletter' => $input['newsletter']
            ];

            $clientData['company_id'] = $this->getCompanyId();

//            if ($recommendation != null) {
            $clientData['recommendation_id'] = $recommendation->id;
//            }
            if ($request->has('benefit') && isset($request->benefit)) {
                $clientData['benefit_id'] = $request->benefit;
            }

            $client = Clients::create($clientData);

            if ($request->has('note') && isset($request->note)) {
                Note::create(['user_id' => $client->id, 'body' => $request['note']]);
            }
            /* activity()->performedOn($client)
                 ->causedBy(auth()->user())
                 //    ->withProperties(['customProperty' => 'customValue'])
                 ->log('Adicionou o cliente ' . $client->name . ' ' . $client->last_name);
            */
            if (!$client) {
                throw new \Exception('User not created for account', 400);
            }

            return $client;
        });

        toastr()->success('Cliente:' . $client->name . ' criado com sucesso', 'Client');
        return redirect()->route('admin.clients.index');
    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($slug)
    {
        $client = Clients::wherePid($slug)->first();
        if ($client->company_id != $this->getCompanyId()) {
            return abort(403, 'Nenhum Resultado Encontrado');
        }
        $form = ['route' => ['admin.clients.update', $slug], 'method' => 'put'];
        $benefits = [];
        foreach (Benefits::where('company_id', $this->getCompanyId())->get() as $benefit) {
            $benefits[] = ['name' => $benefit->name, 'value' => $benefit->id];
        }
        return view('admin.client.form', compact('client', 'form', 'benefits', 'slug'));
    }

    /**
     * @param Request $request
     * @param $slug
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Throwable
     */
    public function update(Request $request, $slug)
    {
        $data = $request->all();
        $data['company_id'] = $this->getCompanyId();
        $data['cep'] = numberClear($request->cep);


        $client = DB::transaction(function () use ($data, $slug) {
            $client = Clients::wherePid($slug)->first();
            if ($client->company_id != $this->getCompanyId()) {
                return abort(403);
            }
            $client->update($data);
            return $client;
        });
        return redirect()->route('admin.clients.index')->with('success', 'Cliente: ' . $client->name . ' atualizado com sucesso');
    }

    /**
     * @param $slug
     */
    public function destroy($slug)
    {
        $client = Clients::wherePid($slug);
        if ($client->delete()) {
            toastr()->success('Cliente: ' . $client->name . ' removido com sucesso');
            return redirect()->route('admin.clients.index');
        }
        toastr()->error('Falha ao remover');
        return redirect()->route('admin.clients.index');
    }

    /**
     * Exibe todas as faturas, status e valores.
     * @param $slug
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @route admin.clients.payments
     */

    public function payments($slug)
    {
        // Exbibe pagamentos ou Boletos caso exista.

        $client = Clients::whereSlug($slug)->first();
        $billets = Billets::whereClientId($client->id)->get();
        return view('admin.client.payments', compact('client', 'billets', 'slug'));
    }
}
