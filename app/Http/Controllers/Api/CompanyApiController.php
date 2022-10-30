<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyApiController extends Controller
{
    public function index()
    {
        return Company::all();
    }

    /**
     * @param Request $request
     * @return Company|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|never|object|null
     */
    public function show(Request $request)
    {
        return $this->getCompany($request);
    }

    /**
     * @param Request $request
     * @return Company|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|never|object|null
     */
    private function getCompany(Request $request)
    {
        $request->validate(['id' => 'integer', 'email' => 'email', 'pid' => 'string']);
        $company = Company::where('id', $request->id);

        if ($request->has('email')) {
            $company->orWhere('email', '=', $request->email);
        }
        if ($request->has('pid')) {
            $company->orWhere('pid', '=', $request->pid);
        }
        $company = $company->first();
        if (!$company) {
            return abort(404, __('error.NotFound'));
        }
        return $company->first();
    }

    /**
     * @param Request $request
     * @param bool $banned
     * @return \Illuminate\Http\JsonResponse|never
     */
    private function banToggle(Request $request, bool $banned)
    {
        $this->middleware('role:admin');
        $company = $this->getCompany($request);
        $company->banned = $banned;

        if ($company->save()) {
            cache()->forget('company:' . $company->id);
            return response()->json('OK', 200);
        }
        return abort(422, __('error.NotAllowed'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|never
     */
    public function ban(Request $request)
    {
        return $this->banToggle($request, true);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|never
     */
    public function unBan(Request $request)
    {
        return $this->banToggle($request, false);
    }
}
