<?php

namespace App\Http\Controllers\Adm;

use App\Actions\TreatmentRequest\CreateNewLawyer;
use App\DataTables\LawyerDataTable;
use App\Http\Controllers\Controller;
use App\Models\Lawyer;
use App\Traits\CompanySessionTraits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class LawyerController extends Controller
{
    use CompanySessionTraits;


    /**
     * @param LawyerDataTable $dataTable
     * @return mixed
     */
    public function index(LawyerDataTable $dataTable)
    {
        return $dataTable->render('admin.lawyers.index');
    }

    /**
     * @param $lawyer
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function edit($lawyer)
    {
        $form = ['route' => ['admin.lawyer.update', ['lawyer' => $lawyer]], 'method' => 'put'];
        $lawyer = Lawyer::wherePid($lawyer)->whereCompanyId($this->getCompanyId())->first();
        return view('admin.lawyers.form', compact('form', 'lawyer'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $form = ['route' => ['admin.lawyer.store'], 'method' => 'post'];
        return view('admin.lawyers.form', compact('form'));
    }

    /**
     * @param $lawyer
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function show($lawyer)
    {
        $lawyer = Lawyer::wherePid($lawyer)->whereCompanyId($this->getCompanyId())->first();
        return view('admin.lawyers.show', compact('lawyer'));
    }

    /**
     * @param $lawyer
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function update($lawyer, Request $request)
    {
        $data = new CreateNewLawyer($request);
        $lawyer = Lawyer::wherePid($lawyer)
            ->get()
            ->first()
            ->update($data->update());
        if ($lawyer) {
            toastSuccess('Sucesso ao atualizar');
        } else {
            toastError('Erro ao atualizar');
        }

        return redirect()->route('admin.lawyer.index');
    }

    /**
     * @param $lawyer
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function delete($lawyer)
    {
        $lawyer = Lawyer::wherePid($lawyer)
            ->whereCompanyId($this->getCompanyId())->first()
            ->delete();
        if ($lawyer) {
            toastSuccess('Sucesso ao deletar');
        } else {
            toastError('Erro ao deletar');
        }

        return redirect()->route('admin.lawyer.index');
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function store(Request $request)
    {
        $data = new CreateNewLawyer($request);
        $lawyer = Lawyer::create($data->store());
        if ($lawyer) {
            toastSuccess('Sucesso ao adicionar');
        } else {
            toastError('Erro ao adicionar');
        }

        return redirect()->route('admin.lawyer.index');
    }
}
