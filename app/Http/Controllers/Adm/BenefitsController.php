<?php

namespace App\Http\Controllers\Adm;

use App\DataTables\BenefitDataTable;
use App\Http\Controllers\Controller;
use App\Models\Benefits;
use App\Traits\CompanySessionTraits;
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
    use CompanySessionTraits;

    /**
     * @param Request $request
     * @param BenefitDataTable $dataTable
     * @return mixed
     */
    public function index(Request $request, BenefitDataTable $dataTable)
    {
        return $dataTable->render('admin.benefits.index', compact('request'));
    }


    /**
     * @param $benefit
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($benefit)
    {
        $form = ['route' => ['admin.benefit.update', ['benefit' => $benefit]], 'method' => 'put'];
        $benefit = Benefits::wherePid($benefit)->whereCompanyId($this->getCompanyId())->first();
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
            ->whereCompanyId($this->getCompanyId())->first()
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
            ->whereCompanyId($this->getCompanyId())->first()
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
        $data['company_id'] = $this->getCompanyId();
        $benefit = Benefits::create($data);
        if ($benefit) {
            toastr()->success('Sucesso ao adicionar');
        } else {
            toastError('Erro ao adicionar');
        }

        return redirect()->route('admin.benefit.index');
    }
}
