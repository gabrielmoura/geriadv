<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{

    /**
     * Apenas o gerente deve acessar
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $this->middleware('role:manager');

        $employees = Employee::find(Auth::user()->company()->id)
            ->employees()->get();

        return view('admin.employee.index', compact('employees'));
    }

    /**
     * O admin e o gerente podem acessar
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $employee = Employee::find($id);
        return view('admin.employee.show', compact('company'));
    }

    public function store(Request $request)
    {
        $request->validade();
        $employee = Employee::create([
            '' => $request

        ]);
        if ($employee) {
            toastr()->success('Funcionário criado com sucesso.');
        }
        return redirect()->route('admin.employee.index');
    }

    public function update(Request $request)
    {
        $request->validade();
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
        //$user = User::find($id);
        $employee = Employee::find($id);
        return view('admin.employee.form', compact('form', 'employee'));
    }

}
