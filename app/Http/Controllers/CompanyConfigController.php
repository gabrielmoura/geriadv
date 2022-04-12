<?php

namespace App\Http\Controllers;

use App\Jobs\Company\ForgetCompanyJob;
use App\Traits\CompanySessionTraits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompanyConfigController extends Controller
{
    use CompanySessionTraits;

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function index()
    {
        $company = $this->getCompany();
        return view('auth.profile.company', compact('company'));
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function update(Request $request)
    {
        $company = $this->getCompany();
        $data = collect($request->toArray());
        if ($request->hasFile('logo')) {

            $url = $request->file('logo')->storePublicly('logos'); //   Define upload como publico.
            $company->logo = Storage::url($url);
            $company->save();
            $this->forgetCompany();
//            ForgetCompanyJob::dispatch($this->getCompanyId());
            return response()->json(null, 204);
        }
        if ($request->has('cep')) {
            $data = $data->replace(['cep' => numberClear($request->cep)]);
            $data = $data->replace(['number' => numberClear($request->number)]);
        }
        if ($company->update($data->toArray())) {
            $this->forgetCompany();
            toastr()->success('Atualizado com sucesso.');
            return redirect()->route('company.setting');
        }
        return redirect()->route('company.setting');

    }
}
