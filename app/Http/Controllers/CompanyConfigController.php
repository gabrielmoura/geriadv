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
     * @return \Illuminate\Http\JsonResponse
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function update(Request $request)
    {
        $company = $this->getCompany();
        if ($request->hasFile('logo')) {

            $url = $request->logo->store('logos');
            $company->logo = Storage::url($url);
            $company->save();
            ForgetCompanyJob::dispatch($this->getCompanyId());
            return response()->json(null, 204);
        }
        $company->update($request->toArray());
        return response()->json(null, 204);

    }
}
