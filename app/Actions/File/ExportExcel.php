<?php


namespace App\Actions\File;


use App\Models\Clients;
use Maatwebsite\Excel\Facades\Excel;

class ExportExcel
{
    public function export(Excel $excel, Clients $clients)
    {
        return $excel->download($clients, 'clients');
    }

    public function exportView(Excel $excel, ClientV $ClientView)
    {
        return $excel->download($ClientView, 'clients');
    }
}
