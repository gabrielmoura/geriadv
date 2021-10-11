<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Controller;
use App\Models\Employee;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{    
    /**
     * Apenas o gerente deve acessar
     *
     * @return void
     */
    public function index(){
        $this->middleware('role:manager');
    
        $employees=Employee::find(Auth::user()->company()->id)
        ->employees()->get();

        return view('admin.employee.index',compact('employees'));
    }    
    /**
     * O admin e o gerente podem acessar
     *
     * @param  mixed $id
     * @return void
     */
    public function show($id){
        $employee=Employee::find($id);
        return view('admin.employee.show',compact('company'));
    }
     
    public function store(Request $request){
        $request->validade();
        $employee=Employee::create([
            ''=>$request

        ]);
        if($employee){
            toastr()->success('Funcionário criado com sucesso.');
        }
        return redirect()->route('admin.employee.index');
    }
    public function update(Request $request){
        $request->validade();
        $employee=Employee::update([
            ''=>$request

        ]);
        if($employee){
            toastr()->success('Funcionário atualizado com sucesso.');
        }
        return redirect()->route('admin.employee.index');
    }
    public function delete(Request $request){
        $employee=Employee::findOrFail($id)->delete();
        if($employee){
            toastr()->success('Funcionário deletado com sucesso.');
        }
        return redirect()->route('admin.employee.index');
    }
    
    public function edit(){
        $form = ['route' => ['admin.users.update', $id], 'method' => 'put'];
        //$user = User::find($id);
        $employee=Employee::find($id);
        return view('admin.employee.form',compact('form','employee'));
    }

}