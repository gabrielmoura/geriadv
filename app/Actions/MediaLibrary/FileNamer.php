<?php


namespace App\Actions\MediaLibrary;

use Spatie\MediaLibrary\Conversions\Conversion;

/**
 * Class FileNamer
 * @package App\Actions\MediaLibrary
 */
class FileNamer extends \Spatie\MediaLibrary\Support\FileNamer\FileNamer
{
    /**
     * @param string $fileName
     * @param Conversion $conversion
     * @return string
     */
    public function conversionFileName(string $fileName, Conversion $conversion): string
    {
        $strippedFileName = md5(pathinfo($fileName, PATHINFO_FILENAME));

        return "{$strippedFileName}-{$conversion->getName()}";
    }

    /**
     * @param string $fileName
     * @return string
     */
    public function responsiveFileName(string $fileName): string
    {
        //return pathinfo($fileName, PATHINFO_FILENAME);
        return md5(pathinfo($fileName, PATHINFO_FILENAME));
    }
}
