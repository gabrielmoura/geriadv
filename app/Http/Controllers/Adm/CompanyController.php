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

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $this->middleware(['role:admin']);


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

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        //$request->validade();
        $data = $request->all();
        $data['cep'] = numberClear($request['cep']);
        $data['tel0'] = numberClear($request['tel0']);
        $data['cnpj'] = numberClear($request['cnpj']);
        $company = Company::create($data);

        if ($company) {
            toastr()->success('Companhia criada com sucesso.');
        } else {
            toastr()->error('Erro ao criar Companhia;');
        }
        return redirect()->route('admin.company.index');
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id, Request $request)
    {
        //$request->validade();
        $data = $request->all();
        $data['cep'] = numberClear($request['cep']);
        $data['tel0'] = numberClear($request['tel0']);
        $data['cnpj'] = numberClear($request['cnpj']);
        $company = Company::find($id)->update($data);
        if ($company) {
            toastr()->success('Companhia atualizada com sucesso.');
        } else {
            toastr()->error('Erro ao atualizar Companhia;');
        }
        return redirect()->route('admin.company.index');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $company = Company::find($id)->delete();
        if ($company) {
            toastr()->success('Companhia deletada com sucesso.');
        } else {
            toastr()->error('Erro ao deletar Companhia;');
        }
        return redirect()->route('admin.company.index');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $this->middleware(['role:admin|manager']);
        $company=Company::find($id);
        $form = ['route' => ['admin.company.update',$id], 'method' => 'put'];
        return view('admin.company.form', compact('form','company'));
    }


}
