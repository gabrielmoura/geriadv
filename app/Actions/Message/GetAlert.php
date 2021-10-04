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
        $limit=5;
        return Auth::user()->unreadNotifications()->limit($limit)->get();
        //return collect($notifications);
    }
}
