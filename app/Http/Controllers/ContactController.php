<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\User;
use App\Notifications\PushDemo;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Jenssegers\Agent\Facades\Agent;

class ContactController extends Controller
{
    use ValidatesRequests;

    public function index(){
        // Ler mensagens
        $this->middleware('role:admin');
    }
    public function store(ContactRequest $request)
    {
        //  Caso seja um bot retornar 401: Não Autorizado.
        if(Agent::isRobot($request->userAgent())){
            return abort(401);
        }
        // Recebe mensagens
        // Pode conter spam

    }
    public function markRead(Request $request){
        // Marca como lido, ou deleta mensagens
    }
}
