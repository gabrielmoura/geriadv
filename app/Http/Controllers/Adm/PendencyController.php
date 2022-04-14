<?php

namespace App\Http\Controllers\Adm;

use App\Events\Client\Pendency\PendencyDownload;
use App\Events\Client\Pendency\PendencyStore;
use App\Http\Controllers\Controller;
use App\Models\Clients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

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
            $pendencyId=$model->pendency()->create(['pendency' => json_encode([])]);
            $model->pendency_id = $pendencyId->id;
            $model->save();

        }
        $pendencyModel=$model->pendency()->first();
        $pendencySet=$pendencyModel->pendency; // Retorna uma Collection

        foreach ($request->allFiles() as $index => $doc) {
            $data[$index] = true;
            $pendencyModel->addMedia($doc)->toMediaCollection($index);
        }


        $pendency = $pendencyModel->update(['pendency'=>$pendencySet->merge($data)->toArray()]);


        if (!$pendency) {
            toastr()->error('Erro ao enviar');
            return redirect()->route('admin.clients.show', ['client' => $request->slug]);
        }
        event(new PendencyStore($pendency));
        toastr()->success('Enviado com sucesso');
        return redirect()->route('admin.clients.show', ['client' => $request->slug]);
    }

    public function delete(Request $request)
    {
        $this->middleware('role:admin|manager');

        //Buscar Pendencias pelo Cliente
        $model = Clients::whereSlug($request->slug)->first()->pendency()->first();
        
        //Remover a pendencia desejada caso exista
        $media=$model->getMedia($request->doc);
        if($media->isNotEmpty()){
            $media->first()->delete();    
        }

        $pendencySet=$model->pendency->replace([$request->doc=>false]);
        // Atualizar tabela de pendencias
        $pendency = $model->update(['pendency'=>$pendencySet->toArray()]);
        
        if (!$pendency) {
            toastr()->error('Erro ao enviar');
            return redirect()->route('admin.clients.show', ['client' => $request->slug]);
        }

        toastr()->success('Removido com sucesso');
        return redirect()->route('admin.clients.show', ['client' => $request->slug]);
    }

    public function download(Request $request)
    {
        //Buscar Pendencias pelo Cliente
        $model = Clients::whereSlug($request->slug)->first()->pendency()->first();
        $media = $model->getFirstMedia($request->doc);
        // Baixa apenas a pendencia desejada.
        event(new PendencyDownload($request));
        return Storage::disk($media->disk)->download($media->getPath(), $media->file_name);

    }
}
