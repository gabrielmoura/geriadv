<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

trait ApiTrait
{
    protected function try($run){
        try {
            return response()->json($run);
        }catch (\Exception $e){
            return response()->json(['error'=>$e->getMessage()],$e->getCode());
        }
    }
    public function sendResponse($result, string $message): \Illuminate\Http\JsonResponse
    {
        $response = [
            'success' => true,
            'status'  => 200,
            'code'    => 'success',
            'message' => $message,
            'data'    => $result,
        ];

        return response()->json($response, 200);
    }
}
