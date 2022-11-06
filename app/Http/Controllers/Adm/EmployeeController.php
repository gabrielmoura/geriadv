<?php

namespace App\Http\Controllers\Adm;

use App\DataTables\EmployeeDataTable;
use App\Http\Controllers\Controller;
use App\Mail\Company\WelcomeCompanyMail;
use App\Models\Employee;
use App\Models\User;
use App\Traits\CompanySessionTraits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class EmployeeController extends Controller
{
    use CompanySessionTraits;

    /**
     * @param Request $request
     * @param EmployeeDataTable $dataTable
     * @return mixed
     */
    public function index(Request $request, EmployeeDataTable $dataTable)
    {
        return $dataTable->render('admin.employee.index', compact('request'));
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
        $employee = Employee::where('pid', $id)->first();
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
            return [$employee, $user];
        });

        if ($transaction[0]) {
            Mail::to($transaction[1])->send(new WelcomeCompanyMail($this->getCompanyId(), $transaction[1]));
            toastr()->success('Funcionário criado com sucesso.');
        }
        return redirect()->route('admin.employee.index');
    }

    public function update(Request $request)
    {

        $data = $request->all();
        $employee = Employee::where('pid', $request->id)->first();
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

        $employee = Employee::where('pid', $id)->first();
        return view('admin.employee.form', compact('form', 'employee'));
    }

}
