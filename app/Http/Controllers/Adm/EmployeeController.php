<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{

    /**
     * Apenas o gerente deve acessar
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $employees = Employee::where('company_id', session()->get('company_id'))->get();

        return view('admin.employee.index', compact('employees'));
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
        $employee = Employee::update([
            '' => $request

        ]);
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
        $form = ['route' => ['admin.users.update', $id], 'method' => 'put'];

        $employee = Employee::find($id);
        return view('admin.employee.form', compact('form', 'employee'));
    }

}
