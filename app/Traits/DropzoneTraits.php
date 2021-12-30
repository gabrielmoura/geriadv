<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait DropzoneTraits
{

    /**
     * @var string
     */
    protected $tmpDir = 'tmp/uploads';


    /**
     * @param Request $request
     * @param string $fileName
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeMediaZone(Request $request, $fileName = 'file')
    {
        $path = storage_path($this->tmpDir);
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $file = $request->file($fileName);

        $name = uniqid() . '_' . trim($file->getClientOriginalName());

        $file->move($path, $name);

        return response()->json([
            'name' => $name,
            'original_name' => $file->getClientOriginalName(),
        ]);
    }


    /**
     * @param Request $request
     * @param object $model
     * @return \Illuminate\Http\RedirectResponse
     */
    public function parseMediaZone(Request $request, object $model)
    {

        foreach ($request->input('document', []) as $file) {
            $model->addMedia(storage_path($this->tmpDir . $file))->toMediaCollection('document');
        }

        return true;
    }


    /**
     * @param Request $request
     * @param object $project
     * @return bool
     */
    public function updateMediaZone(Request $request, object $project)
    {


        if (count($project->document) > 0) {
            foreach ($project->document as $media) {
                if (!in_array($media->file_name, $request->input('document', []))) {
                    $media->delete();
                }
            }
        }

        $media = $project->document->pluck('file_name')->toArray();

        foreach ($request->input('document', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $project->addMedia(storage_path($this->tmpDir . $file))->toMediaCollection('document');
            }
        }

        return true;
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        $form = ['route' => ['admin.upload.dropzone'], 'method' => 'post', 'files' => true];
        return view('layouts.partials.dropzone', compact('form'));
    }


}
