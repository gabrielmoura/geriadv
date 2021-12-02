<?php

namespace App\Http\Controllers\Import;

use App\Http\Controllers\Controller;
use App\Jobs\Import\ImportExcelJob;
use App\Models\Company;
use Illuminate\Http\Request;

class ImportContratosAssinadosExcel extends Controller
{
    public function index()
    {
    }

    public function store(Request $request)
    {
        //return Excel::import(new ImportContratosAssinadosExcel, request()->file('file'));
        $company = Company::find(session()->get('company.id'))->addMedia(request()->file('file'))->toMediaCollection($request->type);
        ImportExcelJob::dispatch($request->type, $company);
        toastr()->success('Processo adicinoado a fila');
    }
}
