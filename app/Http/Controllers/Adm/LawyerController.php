<?php

namespace App\Http\Controllers\Adm;

use App\Actions\TreatmentRequest\CreateNewLawyer;
use App\Http\Controllers\Controller;
use App\Models\Lawyer;
use App\Traits\CompanySessionTraits;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class LawyerController extends Controller
{
    use CompanySessionTraits;

    /**
     * @var Builder
     */
    protected $htmlBuilder;

    /**
     * LawyerController constructor.
     * @param Builder $htmlBuilder
     */
    public function __construct(Builder $htmlBuilder)
    {
        $this->htmlBuilder = $htmlBuilder;

    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function index(Request $request)
    {

        $lawyer = Lawyer::where('company_id', $this->getCompanyId());
        if ($request->ajax()) {
            return Datatables::of($lawyer)
                ->addColumn('action', function (Lawyer $lawyer) {
                    return '<div class="table-data-feature"><a href="' . route('admin.lawyer.show', ['lawyer' => $lawyer->id]) . '"><i
                                class="fa fa-eye"></i></a>|<a
                            href="' . route('admin.lawyer.edit', ['lawyer' => $lawyer->id]) . '"><i
                                class="fa fa-edit"></i></a></div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $html = $this->htmlBuilder
            ->addColumn(['data' => 'name', 'name' => 'name', 'title' => 'Nome'])
            ->addColumn(['data' => 'last_name', 'last_name' => 'last_name', 'title' => 'Sobrenome'])
            ->addColumn(['data' => 'email', 'name' => 'email', 'title' => 'Email'])
            ->addColumn(['data' => 'cpf', 'name' => 'cpf', 'title' => 'CPF'])
            ->addColumn(['data' => 'oab', 'name' => 'oab', 'title' => 'OAB'])
            ->addColumn(['data' => 'action', 'name' => 'action', 'title' => 'Ação'])
            ->responsive(true);


        return view('admin.lawyers.index', compact('html'));
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
        $lawyer = Lawyer::whereId($lawyer)->whereCompanyId($this->getCompanyId())->first();
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
        $lawyer = Lawyer::whereId($lawyer)->whereCompanyId($this->getCompanyId())->first();
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
        $lawyer = Lawyer::find($lawyer)->update($data->update());
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
        $lawyer = Lawyer::whereId($lawyer)
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
