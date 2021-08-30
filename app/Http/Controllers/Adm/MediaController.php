<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Controller;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaController extends Controller
{
    public function index(Media $media)
    {
        return response()->json($media->toJson());
    }
}
