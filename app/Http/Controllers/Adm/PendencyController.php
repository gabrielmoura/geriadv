<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Controller;
use App\Models\Clients;
use App\Models\Pendencies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PendencyController extends Controller
{
    /**
     * Recebe documentos
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        if ($request->has('cras')) {
            $data['cras'] = true;
        }
        if ($request->has('cpf')) {
            $data['cpf'] = true;
        }
        if ($request->has('rg')) {
            $data['rg'] = true;
        }
        if ($request->has('birth_certificate')) {
            $data['birth_certificate'] = true;
        }
        if ($request->has('proof_of_address')) {
            $data['proof_of_address'] = true;
        }

        DB::transaction(function () use ($request, $data) {
            try {
                $model = Clients::whereSlug($request->slug)->first();
                foreach ($request->allFiles() as $index => $doc) {
                    $model->addMedia($doc)->toMediaCollection('docs');
                }
                //$activity = activity();
                if ($model->pendency_id) {
                    $pendency = Pendencies::find($model->pendency_id)->update($data);
                    /*$activity->performedOn($pendency)
                        ->causedBy(auth()->user())
                        ->log('Pendencia atualizada'); */
                } else {
                    $pendency = Pendencies::updateOrCreate($data);
                    $model->pendency_id = $pendency->id;
                    /*$activity->performedOn($pendency)
                        ->causedBy(auth()->user())
                        ->log('Pendencia atualizada'); */
                    $model->save();
                }

            } catch (\Exception $e) {
                toastr()->error('Enviado com erro');
                return redirect()->route('admin.clients.show', ['client' => $request->slug]);
            }
        });

        toastr()->success('Enviado com sucesso');
        return redirect()->route('admin.clients.show', ['client' => $request->slug]);
    }

    /**
     * Remover Media
     * @param Request $request
     *
     */
    public function delete(Request $request)
    {
        //Buscar Pendencias pelo Cliente
        $model = Clients::whereSlug($request->slug)->pendency()->first();
        //Remover apenas a pendencia desejada
        $model[$request->doc]->getMedia('docs')->delete();
        //Remover atualizações de pendencias
        Pendencies::find($model->id)->delete();
        //if($model) return toastr()->success('Removido com sucesso.');
        return abort(400);
    }
}
