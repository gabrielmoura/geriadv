<?php

namespace App\Http\Controllers\Import;

use App\Http\Controllers\Controller;
use App\Jobs\Import\ImportExcelCAJob;
use App\Models\User;
use App\Notifications\User\PrivateMessageNotification;
use Illuminate\Http\Request;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class ImportCCAController extends Controller
{
    public function store(Request $request)
    {
        //https://josephsilber.com/posts/2020/07/29/lazy-collections-in-laravel
        $request->validate([
            'file' => 'required:mimes:csv,txt'
        ]);
        $companyId = $request->company_id;
        try {
            $name = (string)now()->format('Ymdhi') . Str::random(16) . '.csv';
            $file = $request->file('file')->storePubliclyAs('/', $name, 'temp');

            // Cria um trabalho em lote
            $batch = Bus::batch([new ImportExcelCAJob($file, $companyId)])
                ->then(function (Batch $batch) use ($file) {
                    $this->sedMessage($batch);
                })->onQueue('process')->dispatch();

            return response()->json($batch->toArray());
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }

    private function sedMessage($e)
    {
        Notification::sendNow(
            User::find(1),
            new PrivateMessageNotification('Import Success', $e ?? null, '', ['name' => 'System Import'])
        );
    }
}
