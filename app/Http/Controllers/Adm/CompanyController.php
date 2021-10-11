<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Employee;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{    
    /**
     * Apenas o Admin pode acessar
     *
     * @return void
     */
    public function index(){
        $this->middleware('role:admin');
        $companies=Company::all();
        return view('admin.company.index',compact('companies'));
    }    
    /**
     * Deverá ser possivel ver informações da empresa em meia tele e listar os clientes na outra parte.
     *
     * @param  mixed $id
     * @return void
     */
    public function show($id){
        $company=Company::find($id);
        return view('admin.company.show',compact('company'));
    }
    public function showIframe($id){
        $company=Company::find($id);
        return view('admin.company.iframe',compact('company'));
    }
    public function store(Request $request){
        $request->validade();
        $company=Company::create([
            ''=>$request

        ]);
        if($company){
            toastr()->success('Companhia criada com sucesso.');
        }
    }
    public function update(Request $request){
        $request->validade();
        $company=Company::update([
            ''=>$request

        ]);
        if($company){
            toastr()->success('Companhia atualizada com sucesso.');
        }
    }
    public function delete(Request $request){

    }
    public function edit(){
        
    }


}