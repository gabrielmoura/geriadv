<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Actions\Company\CreateNewCompany;

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
        $data=new CreateNewCompany($request);
        $company = Company::create($data->store());

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
        $data=new CreateNewCompany($request);
        $company = Company::find($id)->update($data->update());
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
        $company = Company::find($id);
        $form = ['route' => ['admin.company.update', $id], 'method' => 'put'];
        return view('admin.company.form', compact('form', 'company'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function ban($id)
    {
        $company = Company::find($id)->update(['banned' => true]);
        if ($company) {
            toastr()->success('Companhia banida com sucesso.');
        } else {
            toastr()->error('Erro ao banir Companhia;');
        }
        return redirect()->route('admin.company.index');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unban($id)
    {
        $company = Company::find($id)->update(['banned' => false]);
        if ($company) {
            toastr()->success('Companhia desbanir com sucesso.');
        } else {
            toastr()->error('Erro ao desbanir Companhia;');
        }
        return redirect()->route('admin.company.index');
    }


}
