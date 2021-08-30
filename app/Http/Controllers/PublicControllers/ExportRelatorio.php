<?php

namespace App\Http\Controllers\PublicControllers;

use App\Http\Controllers\Controller;
use App\Models\Relatorio;

/**
 * Este deverá expor relatórios para acesso externo
 * Class ExportRelatorio
 * @package App\Http\Controllers\PublicControllers
 */
class ExportRelatorio extends Controller
{
    public function index($public_id)
    {
        $document = Relatorio::where('public_id', $public_id)->get()->first();
        if ($document->confidential) {
            $this->middleware('auth:web');
        }
        if ($document->data != null) {

            return view('', compact('document'));
        }
        return abort(404, $this->message[404]);
    }
}
