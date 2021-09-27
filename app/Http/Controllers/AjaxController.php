<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use App\Models\ClientStatus;
use App\Models\LogMovement;
use App\Models\Note;
use App\Models\UserOrder;
use Cagartner\CorreiosConsulta\Facade as Correios;
use Canducci\ZipCode\Facades\ZipCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/**
 * Class AjaxController
 * @package App\Http\Controllers
 */
class AjaxController extends Controller
{


    /**
     * Retorna Todas as Rotas
     * @return \Illuminate\Routing\RouteCollectionInterface
     */
    public function routes()
    {
        $this->middleware('role_or_permission:admin');
        return Route::getRoutes();
    }

    public function getCep(Request $request)
    {
        $this->validate($request, ['cep' => 'min:8|max:9']);
        $cep = preg_replace('/[^0-9]/', '', $request->cep); //Apenas números;
        if (strlen($cep) != 8) return abort(400); //Diferente de 8 retorna HTTP400;
        return Cache::remember('cep:' . $cep, now()->addMonths(1), function () use ($cep) {
            return ZipCode::find($cep)->getArray();
        });
    }

    public function getFrete()
    {
        $dados = [
            'tipo' => 'sedex', // Separar opções por vírgula (,) caso queira consultar mais de um (1) serviço. > Opções: `sedex`, `sedex_a_cobrar`, `sedex_10`, `sedex_hoje`, `pac`, 'pac_contrato', 'sedex_contrato' , 'esedex'
            'formato' => 'caixa', // opções: `caixa`, `rolo`, `envelope`
            //'cep_destino'       => '89062086', // Obrigatório
            'cep_origem' => config('metadata.cep'), // Obrigatorio
            //'empresa'         => '', // Código da empresa junto aos correios, não obrigatório.
            //'senha'           => '', // Senha da empresa junto aos correios, não obrigatório.
            'peso' => '1', // Peso em kilos
            'comprimento' => '16', // Em centímetros
            'altura' => '11', // Em centímetros
            'largura' => '11', // Em centímetros
            'diametro' => '0', // Em centímetros, no caso de rolo
            // 'mao_propria'       => '1', // Náo obrigatórios
            // 'valor_declarado'   => '1', // Náo obrigatórios
            // 'aviso_recebimento' => '1', // Náo obrigatórios
        ];
        $dados = array_merge($dados, ['cep_destino' => request('cep_destino')]);
        $tracking = Correios::frete($dados);

        return response()->json($tracking);
    }


    /**
     * Deverá Buscar o ultimo status do cliente
     * @param $id
     * @return mixed
     */
    public function getStatus($id)
    {
        return Clients::find($id)->status()->last();
    }

    public function getByStatus($status)
    {
        return ClientStatus::whereStatus($status)->get();
    }

    public function setStatus(Request $request)
    {
        //return Clients::find($id)->status()->create(['status' => $status]);
        $request->validate(['status' => 'unique:client_statuses']);
        $status = DB::transaction(function () use ($request) {
            $status = ClientStatus::create(['status' => $request->status, 'client_id' => $request->clientID, 'employee' => $request->functionaryID]);

            LogMovement::create([
                'body' => 'Atualizou o Status ' . __('view.' . $request->status) . ' ao cliente ' . Clients::find($request->clientID)->fullname,
                'user_id' => auth()->id()]);
            if (!$status) {
                throw new \Exception('Não foi possivel atualizar cliente', 400);
            }
            return $status;
        });
        return $status;
    }


    public function getNote($id)
    {
        return Clients::find($id)->status()->last();
    }

    public function setNote(Request $request)
    {
        //
        //return Clients::find($id)->status()->create(['status' => $status]);
        $status = DB::transaction(function () use ($request) {
            $note = Note::create(['client_id' => $request->id, 'body' => $request->body]);
            LogMovement::create([
                'body' => 'Adicionou observação ao cliente ' . Clients::find($request->clientID)->fullname,
                'user_id' => auth()->id()]);
            if (!$note) {
                throw new \Exception('Não adicionar Observação ao cliente', 400);
            }
            return $note;

        });
    }

}
