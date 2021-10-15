<?php

namespace App\Http\Controllers;

use Pusher\Pusher;

class PusherTestController extends Controller
{
    public function index()
    {
        $options = array(
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'encrypted' => true,
            'host' => 'workspace',
            'port' => 6001,
            'scheme' => 'http'
        );
        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );

        $data['message'] = 'Hello XpertPhp';
        $pusher->trigger('MManhaes.1', 'myevent', $data);

    }

}
