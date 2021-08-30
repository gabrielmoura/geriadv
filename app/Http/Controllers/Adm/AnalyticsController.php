<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\ContactRequest;
use App\Models\Product;
use App\Models\UserOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AnalyticsController extends Controller
{
    public function index()
    {
        $order = UserOrder::whereMonth(
            'created_at', '=', Carbon::now()->subMonth()->month
        );
        $order->count(); //Quantidade de vendas no mes
        $order->sum('price'); //Ganhos no mes

        $clients = Client::whereMonth(
            'created_at', '=', Carbon::now()->subMonth()->month
        );
        $clients->count(); //Quantidade de novos clientes no mes

        $crequest = ContactRequest::whereMonth(
            'created_at', '=', Carbon::now()->subMonth()->month
        );
        $crequest->count(); //Quantidade de Pedidos de contatos no mes

        $products = Product::whereMonth(
            'created_at', '=', Carbon::now()->subMonth()->month
        );
        $products->count(); //Quantidade de Produtos cadastrados no mes

        return view('admin.index');
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
