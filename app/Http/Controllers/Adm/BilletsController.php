<?php

namespace App\Http\Controllers\Adm;


use App\Actions\Payment\PagHiper\Billets;
use App\Http\Controllers\Controller;
use App\Http\Requests\Financial\BilletsRequest as Request;
use App\Jobs\Client\CreateBilletClientJob;
use App\Models\Clients;
use App\Traits\CompanySessionTraits;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class BilletsController extends Controller
{
    use CompanySessionTraits;


    protected $htmlBuilder;
    private $sheduled = false; // True para Agendar a criação dos boletos

    /**
     * LawyerController constructor.
     * @param Builder $htmlBuilder
     */
    public function __construct(Builder $htmlBuilder)
    {
        $this->htmlBuilder = $htmlBuilder;

    }

    public function index(\Illuminate\Http\Request $request)
    {


        if ($request->ajax()) {
            return Datatables::of(Billets::whereCompanyId($this->getCompanyId())->with('clients'))
                ->addColumn('action', function (Billets $billet) {
                    return '<div class="table-data-feature"><a href="' . route('admin.billets.show', ['billet' => $billet->id]) . '"><i
                                class="fa fa-eye"></i></a>|<a
                            href="' . route('admin.billets.edit', ['billet' => $billet->id]) . '"><i
                                class="fa fa-edit"></i></a></div>';
                })
                ->addColumn('fullname', function (Billets $billet) {
                    return (!!$billet->clients) ? $billet->clients->fullname : null;
                })
//                ->filterColumn('fullname', function ($query, $keyword) {
//                    $sql = "CONCAT(name,' ',last_name)  like ?";
//                    return $query->whereRaw($sql, ["%{$keyword}%"]);
//
////                    return $query->clients->whereRaw($sql, ["%{$keyword}%"]);
//                })
                ->rawColumns(['action'])
                ->smart(true) // Pesquisa inteligente em tempo de execução
                ->make(true);
        }
        $html = $this->htmlBuilder
            ->setTableId('billets-table')
            ->addColumn(['data' => 'fullname', 'name' => 'fullname', 'title' => 'Nome'])
            ->addColumn(['data' => 'value_cents', 'name' => 'value_cents', 'title' => 'Valor em centavos'])
            ->addColumn(['data' => 'status', 'name' => 'status', 'title' => 'status'])
            ->addColumn(['data' => 'due_date', 'name' => 'due_date', 'title' => 'Vencimento'])
            ->addColumn(['data' => 'action', 'name' => 'action', 'title' => 'Ação'])
            ->responsive(true)
            ->serverSide(false)
            ->minifiedAjax();


        //Exibe todos os boletos
        return view('admin.financial.billets.index', compact('html'));
    }

    public function create()
    {
        $form = ['route' => ['admin.billets.store'], 'method' => 'post'];
        $clients = Clients::where('company_id', $this->getCompanyId())->get()->map(function ($item, $key) {
            return [
                'name' => $item->fullname,
                'value' => $item->id,
            ];
        })->toArray();

        return view('admin.financial.billets.formJob', compact('clients', 'form'));
    }


    public function store(Request $request)
    {
        $c =collect(['parcel' => $request->parcel, 'client_id' => $request->client_id, 'company_id' => $this->getCompanyId()]);
        $item = ['description' => $request->description, 'price' => $request->price, 'quantity' => $request->quantity];
        $client = Clients::find($request->client_id);
        $payer = ['payer_name' => $client->fullname, 'payer_email' => $client->email, 'payer_cpf_cnpj' => $client->cpf];

        if ($this->sheduled) {
            CreateBilletClientJob::dispatch($c, $item, $payer); //Error: Serialization of 'Closure' is not allowed
            toastr()->success('Boletos em processamento', 'Boleto');
        } else {
            CreateBilletClientJob::dispatchSync($c, $item, $payer);
            toastr()->success('Boletos em processamento', 'Boleto');
        }

        return redirect()->route('admin.billets.index');
    }


    public function show($id)
    {
        //Mostrar boleto ou mostrar cliente com devidos boletos?
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
