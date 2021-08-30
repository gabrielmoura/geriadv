<?php


namespace App\Actions\MediaLibrary;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator as BasePathGenerator;

/**
 * Class PathGenerator
 * @package App\Actions\MediaLibrary
 */
class PathGenerator implements BasePathGenerator
{

    /**
     * @param Media $media
     * @return string
     */
    public function getPath(Media $media): string
    {
        return md5($media->id . config('app.key')) . '/';
    }


    /**
     * @param Media $media
     * @return string
     */
    public function getPathForConversions(Media $media): string
    {
        return md5($media->id . config('app.key')) . '/conversions/';
    }

    /**
     * @param Media $media
     * @return string
     */
    public function getPathForResponsiveImages(Media $media): string
    {
        return md5($media->id . config('app.key')) . '/responsive-images/';
    }
}
