<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Controller;
use App\Models\Clients;
use Illuminate\Http\Request;

class PendencyController extends Controller
{
    /**
     * Recebe documentos
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $data = [];

        $model = Clients::whereSlug($request->slug)->first();

        if ($model->pendency_id == null) {

            $model->pendency_id = $model->pendency()->create(['rg' => false])->id;
            $model->save();

        }


        foreach ($request->allFiles() as $index => $doc) {
            $data[$index] = true;
            $model->pendency()->first()->addMedia($doc)->toMediaCollection($index);

        }


        $pendency = $model->pendency()->first()->update($data);


        if (!$pendency) {
            toastr()->error('Erro ao enviar');
            return redirect()->route('admin.clients.show', ['client' => $request->slug]);
        }

        toastr()->success('Enviado com sucesso');
        return redirect()->route('admin.clients.show', ['client' => $request->slug]);
    }


    public function delete(Request $request)
    {
        $this->middleware('role:admin|manager');

        //Buscar Pendencias pelo Cliente
        $model = Clients::whereSlug($request->slug)->first()->pendency()->first();
        //Remover apenas a pendencia desejada
        $model->getMedia($request->doc)[0]->delete();

        // Atualizar tabela de pendencias
        $pendency = $model->update([$request->doc => false]);

        if (!$pendency) {
            toastr()->error('Erro ao enviar');
            return redirect()->route('admin.clients.show', ['client' => $request->slug]);
        }

        toastr()->success('Removido com sucesso');
        return redirect()->route('admin.clients.show', ['client' => $request->slug]);
    }
}
