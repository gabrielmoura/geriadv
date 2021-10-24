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
        $this->middleware(['role:admin', 'signed']);
        $companies = Company::all();

        return view('admin.company.index', compact('companies'));
    }

    public function create()
    {
        $this->middleware(['role:admin', 'signed']);

        if (!request()->hasValidSignature()) {
            abort(401);
        }
        $form = ['route' => ['admin.company.store'], 'method' => 'post'];
        return view('admin.company.form', compact('form'));
    }

    /**
     * Deverá ser possivel ver informações da empresa em meia tele e listar os clientes na outra parte.
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $company = Company::find($id);
        return view('admin.company.show', compact('company', 'id'));
    }

    /**
     * Devera buscar informaçoes dos clientes
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showIframe($id)
    {
        $company = Company::find($id);

        $employees = $company->employees()->get();
        $clients = $company->clients()->get();
        return view('admin.company.iframe', compact('employees', 'clients'));
    }

    public function store(Request $request)
    {
        //$request->validade();
        $data = $request->all();
        $data['cep'] = preg_replace('/[^0-9]/', '', $request['cep']);
        $data['tel0'] = preg_replace('/[^0-9]/', '', $request['cnpj']);
        $data['cnpj'] = preg_replace('/[^0-9]/', '', $request['tel0']);
        $company = Company::create($data);

        if ($company) {
            toastr()->success('Companhia criada com sucesso.');
        }
    }

    public function update(Request $request)
    {
        //$request->validade();
        $data = $request->all();
        $data['cep'] = preg_replace('/[^0-9]/', '', $request['cep']);
        $data['tel0'] = preg_replace('/[^0-9]/', '', $request['cnpj']);
        $data['cnpj'] = preg_replace('/[^0-9]/', '', $request['tel0']);
        $company = Company::update($data);
        if ($company) {
            toastr()->success('Companhia atualizada com sucesso.');
        }
    }

    public function delete(Request $request)
    {

    }

    public function edit()
    {
        $this->middleware(['role:admin', 'signed']);

        if (!request()->hasValidSignature()) {
            abort(401);
        }
        $form = ['route' => ['admin.company.update'], 'method' => 'put'];
        return view('admin.company.form', compact('form'));
    }


}
