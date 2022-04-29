<?php

namespace App\Actions\Poke;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class PokeController extends Controller
{
    /**
     * @return Response
     */
    public function __invoke(): Response
    {
        return new Response('', 204);
    }
}
