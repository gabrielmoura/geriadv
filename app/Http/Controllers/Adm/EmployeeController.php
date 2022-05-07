<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Controller;
use App\Mail\Company\WelcomeCompanyMail;
use App\Models\Employee;
use App\Models\User;
use App\Traits\CompanySessionTraits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class EmployeeController extends Controller
{
    use CompanySessionTraits;

    /**
     * @var Builder
     */
    protected $htmlBuilder;

    /**
     * EmployeeController constructor.
     * @param Builder $htmlBuilder
     */
    public function __construct(Builder $htmlBuilder)
    {
        $this->htmlBuilder = $htmlBuilder;

    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Exception
     */
    public function index(Request $request)
    {
        //Apenas o gerente deve acessar
        $employees = Employee::where('company_id', $this->getCompanyId());

        if (config('panel.datatable')) {
            return $this->datatable($request, $employees);
        } else {
            return $this->datatable($request, $employees);
            //$employees = $employees->get();
            //return view('admin.employee.index', compact('clients'));
        }
    }

    /**
     * @param $request
     * @param $employees
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Exception
     */
    protected function datatable($request, $employees)
    {
        if ($request->ajax()) {
            return Datatables::of($employees)
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
            ->responsive(true)
            ->serverSide(true)
            ->language('//cdn.datatables.net/plug-ins/1.11.5/i18n/pt-BR.json')
            ->minifiedAjax();


        return view('admin.employee.index', compact('html'));
    }

    public function create()
    {

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
        $transaction = DB::transaction(function () use ($request) {
            $user = User::create(['name' => $request->name
                , 'email' => $request->email
                , 'password' => Hash::make($request->password)
            ]);
            $user->assignRole('employees');
            $employee = Employee::create(['user_id' => $user->id
                , 'company_id' => $this->getCompanyId()
                , 'name' => $request->name
                , 'email' => $request->email
                , 'cep' => numberClear($request->cep)
                , 'cpf' => numberClear($request->cpf)
                , 'tel0' => numberClear($request->tel0)
            ]);
            return [$employee,$user];
        });

        if ($transaction[0]) {
            Mail::to($transaction[1])->send(new WelcomeCompanyMail($this->getCompanyId(), $transaction[1]));
            toastr()->success('Funcionário criado com sucesso.');
        }
        return redirect()->route('admin.employee.index');
    }

    public function update(Request $request)
    {
        // $request->validade();
        $data = $request->all();
        //dd($data);
        $employee = Employee::find($request->id);
        if ($request->has('cep')) {
            $data['cep'] = numberClear($request->cep);
        }
        if ($request->has('cpf')) {
            $data['cpf'] = numberClear($request->cpf);
        }
        if ($request->has('tel0')) {
            $data['tel0'] = numberClear($request->tel0);
        }


        if ($employee->update($data)) {

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
