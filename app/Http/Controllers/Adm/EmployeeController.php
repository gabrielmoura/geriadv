<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class EmployeeController extends Controller
{

    protected $htmlBuilder;

    public function __construct(Builder $htmlBuilder)
    {
        $this->htmlBuilder = $htmlBuilder;

    }
    public function index(Request $request)
    {
        //Apenas o gerente deve acessar
        $employees = Employee::where('company_id', session()->get('company_id'))->get();
        if ($request->ajax()) {
            return (new Datatables())->collection($employees)
                ->addColumn('action', function (Employee $employee) {
                    return '<div class="table-data-feature"><a href="' . route('admin.employee.show', ['employee' => $employee->id]) . '"><i
                                class="fa fa-eye"></i></a>|<a
                            href="' . route('admin.employee.edit', ['employee' => $employee->id]) . '"><i
                                class="fa fa-edit"></i></a></div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $html = $this->htmlBuilder
            ->addColumn(['data' => 'name', 'name' => 'name', 'title' => 'Name'])
            ->addColumn(['data' => 'sex', 'name' => 'sex', 'title' => 'Sexo'])
            ->addColumn(['data' => 'email', 'name' => 'email', 'title' => 'Email'])
            ->addColumn(['data' => 'tel0', 'name' => 'tel0', 'title' => 'Telefone'])
            ->addColumn(['data' => 'address', 'name' => 'address', 'title' => 'Endereços'])
            ->addColumn(['data' => 'birth_date', 'name' => 'birth_date', 'title' => 'Data de Nascimento'])
            ->addColumn(['data' => 'cpf', 'name' => 'cpf', 'title' => 'CPF'])
            ->addColumn(['data' => 'action', 'name' => 'action', 'title' => 'Ação'])
            ->responsive(true);


        return view('admin.employee.index', compact('html'));
    }

    public function create()
    {
        if (!request()->hasValidSignature()) {
            abort(401);
        }
        $form = ['route' => ['admin.employee.store'], 'method' => 'post'];
        return view('admin.employee.form', compact('form'));
    }

    /**
     * O admin e o gerente podem acessar
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $employee = Employee::find($id);
        return view('admin.employee.show', compact('employee'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);
        $employee = DB::transaction(function () use ($request) {
            $user = User::create(['name' => $request->name
                , 'email' => $request->email
                , 'password' => Hash::make($request->password)
            ]);
            $user->assignRole('employees');
            $employee = Employee::create(['user_id' => $user->id
                , 'company_id' => session()->get('company_id')
                , 'name' => $request->name
                , 'email' => $request->email
            ]);
            return $employee;
        });

        if ($employee) {
            toastr()->success('Funcionário criado com sucesso.');
        }
        return redirect()->route('admin.employee.index');
    }

    public function update(Request $request)
    {
        // $request->validade();
        $employee = Employee::find($request->id)->update($request->all());
        if ($employee) {
            toastr()->success('Funcionário atualizado com sucesso.');
        }
        return redirect()->route('admin.employee.index');
    }

    public function delete(Request $request, $id)
    {
        $employee = Employee::findOrFail($id)->delete();
        if ($employee) {
            toastr()->success('Funcionário deletado com sucesso.');
        }
        return redirect()->route('admin.employee.index');
    }

    public function edit($id)
    {
        $form = ['route' => ['admin.employee.update', $id], 'method' => 'put'];

        $employee = Employee::find($id);
        return view('admin.employee.form', compact('form', 'employee'));
    }

}
