<?php


namespace App\Actions\MediaLibrary;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator as BasePathGenerator;
use App\Traits\CompanySessionTraits;
/**
 * Class PathGenerator
 * @package App\Actions\MediaLibrary
 */
class PathGenerator implements BasePathGenerator
{
    use CompanySessionTraits;
    /**
     * @param Media $media
     * @return string
     */
    public function getPath(Media $media): string
    {
        return $this->blurName($media) . '/';
    }


    /**
     * @param Media $media
     * @return string
     */
    public function getPathForConversions(Media $media): string
    {
        return $this->blurName($media) . '/conversions/';
    }

    /**
     * @param Media $media
     * @return string
     */
    public function getPathForResponsiveImages(Media $media): string
    {
        return $this->blurName($media) . '/responsive-images/';
    }
    
    protected function blurName($media): string 
    { 
        //return md5($media->id . config('app.key'));
        
        //  Este retorna um md5 do ID da Empresa.
        return md5($this->getCompanyId()??'master').DIRECTORY_SEPARATOR. $media->getKey();
    }
}
