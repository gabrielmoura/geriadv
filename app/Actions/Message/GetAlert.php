<?php


namespace App\Actions\Message;


use App\Models\NoticeBoard;
use Illuminate\Support\Facades\Auth;

/**
 * Class GetAlert
 * @package App\Actions\Message
 */
class GetAlert
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public static function getMessage()
    {
        return collect();
    }

    /**
     * Retornará ao TopBar os avisos para o condominio.
     * Más ao Super-Admin retornará uma coleção vazia.
     * @return mixed
     */
    public static function getNotice()
    {

        /* return NoticeBoard::where('read', false)
             ->where('condominio_id', Auth::user()->condominio()->get()->first()->id)
             ->get();
 */
        return collect();
    }
}
