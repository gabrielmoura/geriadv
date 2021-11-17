<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Controller;
use App\Models\Lawyer;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class LawyerController extends Controller
{
    protected $htmlBuilder;

    public function __construct(Builder $htmlBuilder)
    {
        $this->htmlBuilder = $htmlBuilder;

    }

    public function index(Request $request)
    {

        $lawyer = Lawyer::where('company_id', session()->get('company_id'))->get();
        if ($request->ajax()) {
            return (new Datatables())->collection($lawyer)
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
            ->addColumn(['data' => 'rg', 'name' => 'rg', 'title' => 'RG'])
            ->addColumn(['data' => 'action', 'name' => 'action', 'title' => 'Ação'])
            ->responsive(true);


        return view('admin.lawyers.index', compact('html'));
    }

    public function edit($lawyer)
    {
        $form = ['route' => ['admin.lawyer.update', ['lawyer' => $lawyer]], 'method' => 'put'];
        $lawyer = Lawyer::whereId($lawyer)->whereCompanyId(session()->get('company_id'))->first();
        return view('admin.lawyers.form', compact('form', 'lawyer'));
    }

    public function create()
    {
        $form = ['route' => ['admin.lawyer.store'], 'method' => 'post'];
        return view('admin.lawyers.form', compact('form'));
    }

    public function show($lawyer)
    {
        $lawyer = Lawyer::whereId($lawyer)->whereCompanyId(session()->get('company_id'))->first();
        return view('admin.lawyers.show',compact('lawyer'));
    }

    public function update($lawyer, Request $request)
    {
        $lawyer = Lawyer::whereId($lawyer)
            ->whereCompanyId(session()->get('company_id'))->first()
            ->update($request->all());
        if ($lawyer) {
            toastInfo('Sucesso ao atualizar');
        } else {
            toastError('Erro ao atualizar');
        }

        return redirect()->route('admin.lawyer.index');
    }

    public function delete($lawyer)
    {
        $lawyer = Lawyer::whereId($lawyer)
            ->whereCompanyId(session()->get('company_id'))->first()
            ->delete();
        if ($lawyer) {
            toastInfo('Sucesso ao deletar');
        } else {
            toastError('Erro ao deletar');
        }

        return redirect()->route('admin.lawyer.index');
    }


    public function store(Request $request)
    {
        $data = $request->all();
        $data['company_id'] = session()->get('company_id');
        $lawyer = Lawyer::create($data);
        if ($lawyer) {
            toastInfo('Sucesso ao adicionar');
        } else {
            toastError('Erro ao adicionar');
        }

        return redirect()->route('admin.lawyer.index');
    }
}
