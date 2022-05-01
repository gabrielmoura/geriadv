<?php

namespace App\Http\Controllers\Adm;

use App\Actions\Payment\PagHiper\Billets;
use App\Http\Controllers\Controller;
use App\Models\Benefits;
use App\Models\Clients;
use App\Models\Note;
use App\Models\Recommendation;
use App\Traits\CompanySessionTraits;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use Yajra\DataTables\Html\Builder;


class ClientController extends Controller
{
    use CompanySessionTraits;

    /**
     * @var Builder
     */
    protected $htmlBuilder;

    /**
     * ClientController constructor.
     * @param Builder $htmlBuilder
     */
    public function __construct(Builder $htmlBuilder)
    {
        $this->htmlBuilder = $htmlBuilder;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function index(Request $request)
    {

        $clients = Clients::where('company_id', $this->getCompanyId())->with(['status','benefit']);

        if ($request->has('name') && !is_null($request->name)) {
            $clients->whereRaw("CONCAT(name,' ',last_name)  like ?", ["%{$request->name}%"]);
        }
        if ($request->has('month') && !is_null($request->month)) {
            $clients = $clients->whereMonth('created_at', $request->month);
        }
        if ($request->has('sex') && !is_null($request->sex)) {
            $clients = $clients->whereSex($request->sex);
        }
        if ($request->has('city') && !is_null($request->city)) {
            $clients = $clients->whereCity($request->city);
        }
        if ($request->has('state') && !is_null($request->state)) {
            $clients = $clients->whereState($request->state);
        }
        if ($request->has('district') && !is_null($request->district)) {
            $clients = $clients->whereDistrict($request->district);
        }
        if ($request->has('status') && !is_null($request->status)) {
            $clients = $clients->whereHas('status', function ($query) use ($request) {
                $query->where('status', 'like', $request->status);
            });
        }
        if ($request->has('recommendation') && !is_null($request->recommendation)) {
            $clients = $clients->whereHas('recommendation', function ($query) use ($request) {
                $query->where('name', 'like', $request->recommendation);
            });
        }


        // Caso o Admin também deseje ter acesso a os clientes.

        if ($this->hasRole('admin') && $this->hasPermission('edit_client')) {
            $clients = Clients::query();
        }
        if (config('panel.datatable')) {
            return $this->datatable($request, $clients);
        } else {
            $clients = $clients->get();
            return view('admin.client.index', compact('clients', 'request'));
        }

    }

    /**
     * @param $request
     * @param $client
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Exception
     */
    protected function datatable($request, $client)
    {


        if ($request->ajax()) {
            return Datatables::of($client)
                ->addIndexColumn()
                ->addColumn('action', function (Clients $client) {
                    return $this->dataAction('admin.clients', $client->slug);
                })
                ->addColumn('fullname', function (Clients $client) {
                    return $client->fullname;
                })
                ->addColumn('benefit', function (Clients $client) {
                    return (!!$client->benefit) ? __( $client->benefit->name) : null;
                })
                ->addColumn('status', function (Clients $client) {
                    return (!!$client->status) ? __('view.' . $client->status->status) : null;
                })
                ->addColumn('lastupdate', function (Clients $client) {
                    return (!!$client->status) ? date_format($client->status->created_at,'d/m/Y h:i') : null;
                })
                ->filterColumn('fullname', function ($query, $keyword) {
                    $sql = "CONCAT(name,' ',last_name)  like ?";
                    return $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->rawColumns(['action'])
                ->smart(true) // Pesquisa inteligente em tempo de execução
                ->make(true);
        }

        $html = $this->htmlBuilder
            ->setTableId('clients-table')
            ->addColumn(['data' => 'fullname', 'name' => 'fullname', 'title' => 'Nome'])
            ->addColumn(['data' => 'sex', 'name' => 'sex', 'title' => 'Sexo'])
            ->addColumn(['data' => 'email', 'name' => 'email', 'title' => 'Email'])
            ->addColumn(['data' => 'tel0', 'name' => 'tel0', 'title' => 'Telefone'])
            ->addColumn(['data' => 'birth_date', 'name' => 'birth_date', 'title' => 'Data de Nascimento'])
            ->addColumn(['data' => 'cpf', 'name' => 'cpf', 'title' => 'CPF'])
            ->addColumn(['data' => 'benefit', 'name' => 'benefit', 'title' => 'Beneficio'])
            ->addColumn(['data' => 'status', 'name' => 'status.status', 'title' => 'Status'])
            ->addColumn(['data' => 'lastupdate', 'name' => 'status.created_at', 'title' => 'Ultima Modificação', 'searchable' => false])
            ->addColumn(['data' => 'action', 'name' => 'action', 'title' => 'Ação'])
            ->responsive(true)
            ->serverSide(true)
            ->language('//cdn.datatables.net/plug-ins/1.11.5/i18n/pt-BR.json')
            ->searching(false)
            ->minifiedAjax();
        return view('admin.client.datatable', compact('html', 'request'));
    }

    public function dataAction($route, $id, $action = ['view', 'edit'])
    {
        $v = '<div class="table-data-feature">';
        $e = '</div>';
        if (in_array('view', $action)) {
            $v .= '<a href="' .
                route($route . '.show', ['client' => $id])
                . '" class="item" data-toggle="tooltip" data-placement="top" data-original-title="Ver"><i class="fa fa-eye"></i></a> ';
        }

        if (in_array('edit', $action) && $this->hasPermission('edit_client')) {
            $e = '<a href="'
                . route($route . '.edit', ['client' => $id])
                . '" class="item" data-toggle="tooltip" data-placement="top" data-original-title="Editar"><i class="fa fa-edit"></i></a></div>';
        }

        return $v . $e;

    }

    /*
     public function index()
{
    $clients = Clients::where('company_id', $this->getCompanyId())->get();
    if (request()->has('filter')) {
        $clients = $clients->filter(function ($value, $key) {
            return $value->status != null;
        });
    }
    return view('admin.client.index', compact('clients'));
}
    */


    /**
     * @param $slug
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function show($slug)
    {
        $client = Clients::with(['pendency', 'benefit', 'recommendation', 'status', 'billets','media'])->whereSlug($slug)
            ->where('company_id', $this->getCompanyId())
            ->first();
            $pendency=$client->pendency;
        return view('admin.client.show', compact('client','pendency'));
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
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
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
            , 'benefit' => 'required|numeric'
        ]);

        $client = DB::transaction(function () use ($request) {
            $recommendation = (!is_null($request->recommendation)) ?Recommendation::create(['name' => $request->recommendation]):null;
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

            $clientData['company_id'] = $this->getCompanyId();

            if ($recommendation!=null) {
                $clientData['recommendation_id'] = $recommendation->id;
            }
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
        $client = Clients::whereSlug($slug)->first();
        $form = ['route' => ['admin.clients.update', $slug], 'method' => 'put'];
        $benefits = [];
        foreach (Benefits::where('company_id', $this->getCompanyId())->get() as $benefit) {
            $benefits[] = ['name' => $benefit->name, 'value' => $benefit->id];
        }
        return view('admin.client.form', compact('client', 'form', 'benefits','slug'));
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


        $client = DB::transaction(function () use ($data, $slug) {
            $client = Clients::whereSlug($slug)->first();
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
        $client = Clients::whereSlug($slug);
        if($client->delete()){
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
