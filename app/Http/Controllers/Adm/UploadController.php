<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Controller;
use App\Traits\DropzoneTraits;
use Illuminate\Http\Request;
class UploadController extends Controller
{
    use DropzoneTraits;
    public function storeMedia(Request $request){
        if(config('panel.libUpload')=='dropZone'){
            $this->storeMediaZone($request);
        }else{
            return abort(401);
        }
    }

}
