<?php
use Illuminate\Http\Request;
namespace App\Actions\Rule;


/**
 * ClientsRule
 */
class ClientsRule{    
            
    /**
     * Status
     *
     * @param  mixed $request
     * @return void
     */
    public static function Status(Request $request){
        $clientStatus=ClientStatus::whereClientId($request->clientID);
        // Se Status já for duplicado abortar
        if ($clientStatus->where('status', $request->status)->count()>2) return abort(400,'Limite excedido');
        [['value'=>'deferred','name'=>'Deferido'],['value'=>'rejected','name'=>'Indeferido'],['value'=>'analysis','name'=>'Analise'],['value'=>'called_off','name'=>'Cancelado'],['value'=>'deceased','name'=>'Falecido'],['value'=>'cancellation','name'=>'Solicitou Cancelamento']];
        // Se foi deferido não há por que entrar em analise
        if($clientStatus->where('status', 'deferred')->count() == 1 && $request->status=='analysis') return abort();
        // Se indeferido, analise OK
        // Se Cancelado, deferido ou indeferido abortar
        if($clientStatus->where('status', 'called_off')->count() == 1 && $request->status=='rejected'||$clientStatus->where('status', 'called_off')->count() == 1 && $request->status=='deferred') return abort();
        // Se Falecido, deferido, indeferido, analise, abortar
        if($clientStatus->where('status', 'deceased')->count() == 1 ) return abort();
        // Se Solicitou Cancelamento, 
        return $request;
    }
}