<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{

    /**
     * Apenas o Admin deve acessar
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $this->middleware('role:admin');
        $companies = Company::all();
        return view('admin.company.index', compact('companies'));
    }

    /**
     * Deverá ser possivel ver informações da empresa em meia tele e listar os clientes na outra parte.
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $company = Company::find($id);
        return view('admin.company.show', compact('company'));
    }

    /**
     * Devera buscar informaçoes dos clientes
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showIframe($id)
    {
        $company = Company::find($id);
        return view('admin.company.iframe', compact('company'));
    }

    public function store(Request $request)
    {
        $request->validade();
        $company = Company::create([
            '' => $request

        ]);
        if ($company) {
            toastr()->success('Companhia criada com sucesso.');
        }
    }

    public function update(Request $request)
    {
        $request->validade();
        $company = Company::update([
            '' => $request

        ]);
        if ($company) {
            toastr()->success('Companhia atualizada com sucesso.');
        }
    }

    public function delete(Request $request)
    {

    }

    public function edit()
    {

    }


}
