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
                    return '<div class="table-data-feature"><a href="' . route('admin.benefit.show', ['benefit' => $lawyer->id]) . '"><i
                                class="fa fa-eye"></i></a>|<a
                            href="' . route('admin.benefit.edit', ['benefit' => $lawyer->id]) . '"><i
                                class="fa fa-edit"></i></a></div>';
                })
                ->addColumn('amount', function (Lawyer $lawyer) {
                    return (is_null($lawyer->wage)) ? config('core.minimum.salary') * $lawyer->wage_factor : $lawyer->wage * $lawyer->wage_factor;
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


        return view('admin.lawyers.index', compact('html'));
    }

    public function edit($lawyer)
    {
        $form = ['route' => ['admin.benefit.update', ['benefit' => $lawyer]], 'method' => 'put'];
        $benefit = Lawyer::whereId($lawyer)->whereCompanyId(session()->get('company_id'))->first();
        return view('admin.lawyers.form', compact('form', 'benefit'));
    }

    public function create()
    {
        $form = ['route' => ['admin.lawyer.store'], 'method' => 'post'];
        return view('admin.lawyers.form', compact('form'));
    }

    public function show()
    {
        return view('');
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
