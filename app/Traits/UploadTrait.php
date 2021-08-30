<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

trait UploadTrait
{
    /**
     * @param $images
     * @param null $imageColumn
     * @return array
     */
    private function imageUpload($images, string $dir = 'temp')
    {
//https://nfandrich.net/laravel-upload-and-resize-images-using-intervention-image/
        $uploadedImages = [];
        if (is_array($images)) {
            foreach ($images as $index => $image) {

                $uploadedImages[$index]['image'] = $image->store($dir, 'public');

                $filename = Str::random(40);
                $file = $dir . '/' . $filename . '.jpg';
                $realPatch = storage_path('app/public/' . $file);
                Image::make($image)->resize(348, 348)->save($realPatch, 75);
                $uploadedImages[$index]['thumb'] = $file;

                $filename = Str::random(40);
                $file = $dir . '/' . $filename . '.jpg';
                $realPatch = storage_path('app/public/' . $file);
                Image::make($image)->resize(900, 900)->save($realPatch);
                $uploadedImages[$index]['full'] = $file;
            }
        } else {
            $uploadedImages['image'] = $images->store($dir, 'public');

            $filename = Str::random(40);
            $file = $dir . '/' . $filename . '.jpg';
            $realPatch = storage_path('app/public/' . $file);
            Image::make($images)->resize(348, 348)->save($realPatch, 75);
            $uploadedImages['thumb'] = $file;

            $filename = Str::random(40);
            $file = $dir . '/' . $filename . '.jpg';
            $realPatch = storage_path('app/public/' . $file);
            Image::make($images)->resize(900, 900)->save($realPatch);
            $uploadedImages['full'] = $file;
        }
        return $uploadedImages;
    }

    /**
     * Recebe Instancia do Model, Request e os salva.
     * @param $model
     * @param $images
     * @param string $collection
     */
    private function imageUploadV2($model, $images, string $collection = 'product')
    {
        //Usando Spatie/laravel-medialibrary
        if (is_array($images)) {
            foreach ($images as $index => $image) {
                $model->addMedia($image)->toMediaCollection($collection);
            }
        } else {
            $model->addMedia($images)->toMediaCollection($collection);
        }
    }
}
