<?php

namespace App\Http\Controllers\Import;

use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Actions\Excel\Import\ImportContratosAssinadosExcel as Import;

class ImportContratosAssinadosExcel extends Controller
{
    public function index()
    {
    }

    public function store()
    {
       //return Excel::import(new ImportContratosAssinadosExcel, request()->file('file'));
        return Excel::toArray(new Import(), storage_path('contratos_assinados.xlsx'));
    }
}
