<?php

namespace App\Http\Controllers\Import;

use App\Http\Controllers\Controller;
use App\Jobs\Import\ImportExcelCAJob;
use Illuminate\Http\Request;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;


class ImportCCAController extends Controller
{
    public function store(Request $request)
    {
        //https://josephsilber.com/posts/2020/07/29/lazy-collections-in-laravel
        $request->validate([
            'file' => 'required:mimes:csv,txt'
        ]);
        $file = $request->file('file')->store('tmp');
        $companyId = $request->company_id;

        // Cria um trabalho em lote
        $batch = Bus::batch([new ImportExcelCAJob($file, $companyId)])
            ->then(function (Batch $batch) {
                // All jobs completed successfully...
            })->onQueue('process')->dispatch();

        return response()->json($batch->toArray());
    }
}
