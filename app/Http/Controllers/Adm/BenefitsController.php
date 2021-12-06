<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Controller;
use App\Models\Benefits;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

/**
 * Gerenciamento de Beneficios
 * Class BenefitsController
 * @package App\Http\Controllers\Adm
 */
class BenefitsController extends Controller
{
    protected $htmlBuilder;

    public function __construct(Builder $htmlBuilder)
    {
        $this->htmlBuilder = $htmlBuilder;

    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {

        $benefits = Benefits::where('company_id', session()->get('company.id'));
        if (config('panel.datatable')) {
            return $this->datatable($request, $benefits);
        } else {
            return $this->datatable($request, $benefits);
            //$benefits = $benefits->get();
        }
    }

    /**
     * @param $request
     * @param $benefits
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Exception
     */
    protected function datatable($request, $benefits)
    {
        if ($request->ajax()) {
            return Datatables::of($benefits)
                ->addColumn('action', function (Benefits $benefits) {
                    return '<div class="table-data-feature"><a href="' . route('admin.benefit.show', ['benefit' => $benefits->id]) . '"><i
                                class="fa fa-eye"></i></a>|<a
                            href="' . route('admin.benefit.edit', ['benefit' => $benefits->id]) . '"><i
                                class="fa fa-edit"></i></a></div>';
                })
                ->addColumn('amount', function (Benefits $benefits) {
                    return calculateAmount($benefits);
                })
                ->rawColumns(['amount', 'action'])
                ->make(true);
        }
        $html = $this->htmlBuilder
            ->addColumn(['data' => 'name', 'name' => 'name', 'title' => 'Nome'])
            ->addColumn(['data' => 'description', 'name' => 'description', 'title' => 'Descrição'])
            ->addColumn(['data' => 'wage_type', 'name' => 'wage_type', 'title' => 'Tipo de Remuneração'])
            ->addColumn(['data' => 'amount', 'name' => 'amount', 'title' => 'Total'])
            ->addColumn(['data' => 'action', 'name' => 'action', 'title' => 'Ação'])
            ->responsive(true)
            ->serverSide(true)
            ->minifiedAjax();


        return view('admin.benefits.index', compact('html'));
    }

    /**
     * @param $benefit
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($benefit)
    {
        $form = ['route' => ['admin.benefit.update', ['benefit' => $benefit]], 'method' => 'put'];
        $benefit = Benefits::whereId($benefit)->whereCompanyId(session()->get('company.id'))->first();
        return view('admin.benefits.form', compact('form', 'benefit'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $form = ['route' => ['admin.benefit.store'], 'method' => 'post'];
        return view('admin.benefits.form', compact('form'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show()
    {
        return view('');
    }

    /**
     * @param $benefit
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($benefit, Request $request)
    {
        $benefit = Benefits::whereId($benefit)
            ->whereCompanyId(session()->get('company.id'))->first()
            ->update($request->all());
        if ($benefit) {
            toastr()->success('Sucesso ao atualizar');
        } else {
            toastError('Erro ao atualizar');
        }

        return redirect()->route('admin.benefit.index');
    }

    /**
     * @param $benefit
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($benefit)
    {
        $benefit = Benefits::whereId($benefit)
            ->whereCompanyId(session()->get('company.id'))->first()
            ->delete();
        if ($benefit) {
            toastr()->success('Sucesso ao deletar');
        } else {
            toastError('Erro ao deletar');
        }

        return redirect()->route('admin.benefit.index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['company_id'] = session()->get('company.id');
        $benefit = Benefits::create($data);
        if ($benefit) {
            toastr()->success('Sucesso ao adicionar');
        } else {
            toastError('Erro ao adicionar');
        }

        return redirect()->route('admin.benefit.index');
    }
}
