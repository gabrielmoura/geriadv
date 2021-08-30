<?php

namespace App\Http\Controllers\PublicControllers;

use App\Http\Controllers\Controller;
use App\Models\Documentos;
use Illuminate\Support\Facades\Response;

class ExportDocument extends Controller
{
    protected $message = [
        404 => "Arquivo não encontrado ou inexistente",
    ];

    /**
     * @param $public_id
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\BinaryFileResponse|void
     */
    public function index($public_id)
    {
        $document = Documentos::where('public_id', $public_id)->get()->first();
        if ($document->confidential) {
            $this->middleware('auth:web');
        }
        if ($document->data != null) {
            return Response::file($document->data);
        }
        if ($document->address != null) {
            return Response::redirectTo($document->address);
        }
        return abort(404, $this->message[404]);
    }
}
