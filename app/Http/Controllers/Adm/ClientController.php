<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Controller;
use App\Models\Benefits;
use App\Models\Clients;
use App\Models\Note;
use App\Models\Recommendation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use Yajra\DataTables\Html\Builder;


class ClientController extends Controller
{
    protected $htmlBuilder;

    public function __construct(Builder $htmlBuilder)
    {
        $this->htmlBuilder = $htmlBuilder;
    }

    public function index(Request $request)
    {
        $clients = Clients::where('company_id', session()->get('company.id'));
        // Caso o Admin também deseje ter acesso a os clientes.
        $user = Auth::user();
        if ($user->hasRole('admin') && $user->hasPermissionTo('edit_client')) {
            $clients = Clients::query();
        }
        if (config('panel.datatable')) {
            return $this->datatable($request, $clients);
        } else {
            $clients = $clients->get();
            return view('admin.client.index', compact('clients'));
        }

    }

    protected function datatable($request, $client)
    {

        if ($request->ajax()) {
            return Datatables::of($client)
                ->addColumn('action', function (Clients $client) {
                    return '<div class="table-data-feature"><a href="' . route('admin.clients.show', ['client' => $client->slug]) . '" class="item" data-toggle="tooltip" data-placement="top" data-original-title="Editar"><i class="fa fa-eye"></i></a></div>';
                })
                ->addColumn('fullname', function (Clients $client) {
                    return $client->fullname;
                })
                ->addColumn('status', function (Clients $client) {
                    return (!!$client->status()->get()->last()) ? __('view.' . $client->status()->get()->last()->status) : '';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $html = $this->htmlBuilder
            ->addColumn(['data' => 'fullname', 'name' => 'fullname', 'title' => 'Nome'])
            ->addColumn(['data' => 'sex', 'name' => 'sex', 'title' => 'Sexo'])
            ->addColumn(['data' => 'email', 'name' => 'email', 'title' => 'Email'])
            ->addColumn(['data' => 'tel0', 'name' => 'tel0', 'title' => 'Telefone'])
            ->addColumn(['data' => 'address', 'name' => 'address', 'title' => 'Endereços'])
            ->addColumn(['data' => 'birth_date', 'name' => 'birth_date', 'title' => 'Data de Nascimento'])
            ->addColumn(['data' => 'cpf', 'name' => 'cpf', 'title' => 'CPF'])
            ->addColumn(['data' => 'status', 'name' => 'Status', 'title' => 'Status'])
            ->addColumn(['data' => 'action', 'name' => 'action', 'title' => 'Ação'])
            ->responsive(true)
            ->serverSide(true)
            ->minifiedAjax();
        return view('admin.client.datatable', compact('html'));
    }

    /*
     public function index()
{
    $clients = Clients::where('company_id', session()->get('company.id'))->get();
    if (request()->has('filter')) {
        $clients = $clients->filter(function ($value, $key) {
            return $value->status != null;
        });
    }
    return view('admin.client.index', compact('clients'));
}
    */


    public function show($slug)
    {
        $client = Clients::whereSlug($slug)
            ->where('company_id', session()->get('company.id'))
            ->first();

        return view('admin.client.show', compact('client'));
    }

    public function create()
    {
        $clients = Clients::where('company_id', session()->get('company.id'))->get();
        $form = ['route' => ['admin.clients.store'], 'method' => 'post'];
        $benefits = [];
        foreach (Benefits::where('company_id', session()->get('company.id'))->get() as $benefit) {
            $benefits[] = ['name' => $benefit->name, 'value' => $benefit->id];
        }
        return view('admin.client.form', compact('clients', 'form', 'benefits'));
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
            $recommendation = Recommendation::create(['name' => $request->recommendation]);
            $clientData = [
                /**
                 * Dados Pessoais
                 */
                'name' => $request['name']
                , 'last_name' => $request['last_name']
                , 'tel0' => numberClear($request['tel0'])
                , 'cpf' => numberClear($request['cpf'])
                , 'sex' => $request['sex']
                , 'birth_date' => Carbon::make($request['birth_date'])

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
            if (session()->has('company_id')) {
                $clientData['company_id'] = session()->get('company.id');
            }
            if (isset($recommendation->id)) {
                $clientData['recommendation_id'] = $recommendation->id;
            }

            $client = Clients::create($clientData);
            if ($request->has('benefit') && isset($request->benefit)) {
                $clientData['benefit_id'] = $request->benefit;
            }
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

    public function edit($slug)
    {
        $clients = Clients::whereSlug($slug)->first();
        $form = ['route' => ['admin.client.update', $slug], 'method' => 'put'];
        return view('admin.client.form', compact('clients', 'form'));
    }

    public function update(Request $request, $slug)
    {
        $data = $request->all();
        if (session()->has('company_id')) {
            $data['company_id'] = session()->get('company.id');
        }

        $client = DB::transaction(function () use ($data, $slug) {
            $client = Clients::whereSlug($slug)->first();
            $client->update($data);
            activity()->performedOn($client)
                ->causedBy(auth()->user())
                //    ->withProperties(['customProperty' => 'customValue'])
                ->log('Atualizou o cliente ' . $client->name . ' ' . $client->last_name);
            return $client;
        });
        return redirect()->route('admin.client.index')->with('success', 'Cliente:' . $client->name . ' atualizado com sucesso');
    }

    public function delete($slug)
    {
        $client = Clients::whereSlug($slug)->delete();
        activity()->performedOn($client)
            ->causedBy(auth()->user())
            //    ->withProperties(['customProperty' => 'customValue'])
            ->log('Deletou o cliente ' . $client->name . ' ' . $client->last_name);

    }
}
