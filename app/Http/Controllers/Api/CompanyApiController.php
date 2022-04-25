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

    public function show($id)
    {
        return Company::find($id);
    }

    public function ban(Request $request)
    {
        $this->middleware('role:admin');

        $company = Company::where('email', $request->email)->orWhere('id', $request->company_id)->first();
        $company->banned = true;

        if ($company->save()) {
            cache()->forget('company:' . $request->company);
            return response()->json([], 200);
        }
        return response()->json([], 422);
    }

    public function unBan(Request $request)
    {
        $this->middleware('role:admin');

        $company = Company::where('email', $request->email)->orWhere('id', $request->company_id)->first();
        $company->banned = false;
        if ($company->save()) {
            cache()->forget('company:' . $request->company);
            return response()->json([], 200);
        }
        return response()->json([], 422);
    }
}
