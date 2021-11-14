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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {

        $benefits = Benefits::where('company_id', session()->get('company_id'))->get();
        if ($request->ajax()) {
            return (new Datatables())->collection($benefits)
                ->addColumn('action', function (Benefits $benefits) {
                    return '<div class="table-data-feature"><a href="' . route('admin.benefit.show', ['benefit' => $benefits->id]) . '"><i
                                class="fa fa-eye"></i></a>|<a
                            href="' . route('admin.benefit.edit', ['benefit' => $benefits->id]) . '"><i
                                class="fa fa-edit"></i></a></div>';
                })
                ->addColumn('amount', function (Benefits $benefits) {
                    return (is_null($benefits->wage)) ? config('core.minimum.salary') * $benefits->wage_factor : $benefits->wage * $benefits->wage_factor;
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
            ->responsive(true);


        return view('admin.benefits.index', compact('html'));
    }

    /**
     * @param $benefit
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($benefit)
    {
        $form = ['route' => ['admin.benefit.update', ['benefit' => $benefit]], 'method' => 'put'];
        $benefit = Benefits::whereId($benefit)->whereCompanyId(session()->get('company_id'))->first();
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
            ->whereCompanyId(session()->get('company_id'))->first()
            ->update($request->all());
        if ($benefit) {
            toastInfo('Sucesso ao atualizar');
        } else {
            toastError('Erro ao atualizar');
        }

        return redirect()->route('admin.benefit.index');
    }

    /**
     * @param $benefit
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($benefit)
    {
        $benefit = Benefits::whereId($benefit)
            ->whereCompanyId(session()->get('company_id'))->first()
            ->delete();
        if ($benefit) {
            toastInfo('Sucesso ao deletar');
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
        $data['company_id'] = session()->get('company_id');
        $benefit = Benefits::create($data);
        if ($benefit) {
            toastInfo('Sucesso ao adicionar');
        } else {
            toastError('Erro ao adicionar');
        }

        return redirect()->route('admin.benefit.index');
    }
}
