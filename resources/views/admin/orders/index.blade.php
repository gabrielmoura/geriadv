@extends('layouts.default')

@section('content')
    {{--    <div class="row">
            <div class="col-12">
                <h2>Pedidos Recebidos</h2>
                <hr>
            </div>

            <div class="col-12">
                <div class="accordion" id="accordionExample">
                    @forelse($orders as $key => $order)
                        <div class="card">
                            <div class="card-header" id="headingOne">
                                <h2 class="mb-0">
                                    <button class="btn btn-link" type="button" data-toggle="collapse"
                                            data-target="#collapse{{$key}}" aria-expanded="true"
                                            aria-controls="collapseOne">
                                        Pedido nº: {{$order->reference}}
                                    </button>
                                </h2>
                            </div>

                            <div id="collapse{{$key}}" class="collapse @if($key == 0) show @endif"
                                 aria-labelledby="headingOne" data-parent="#accordionExample">
                                <div class="card-body">
    <span>
        @if($order->pagseguro_status=='1')
            Aguardando pagamento
        @elseif($order->pagseguro_status=='2')
            Em análise
        @elseif($order->pagseguro_status=='3')
            Paga
        @elseif($order->pagseguro_status=='4')
            Disponível para saque
        @elseif($order->pagseguro_status=='5')
            Em disputa
        @elseif($order->pagseguro_status=='6')
            Devolvida
        @elseif($order->pagseguro_status=='7')
            Cancelada
        @elseif($order->pagseguro_status=='8')
            Debitado
        @elseif($order->pagseguro_status=='9')
            Retenção temporária
        @endif
    </span>
                                    <ul>
                                        @php $items = unserialize($order->items); @endphp
                                        @foreach($items as $item)

                                            <li>
                                                {{$item['name']}} |
                                                R$ {{number_format($item['price'] * $item['quantity'], 2, ',', '.')}}
                                                <br>
                                                Quantidade pedida: {{$item['quantity']}}
                                            </li>
                                        @endforeach
                                    </ul>

                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="alert alert-warning">Nenhum pedido recebido!</div>
                    @endforelse
                </div>

                <div class="col-12">
                    <hr>

                </div>
            </div>
        </div> --}}


    <div class="row">
        <div class="col-md-9">
            <div class="osahan-account-page-right shadow-sm bg-white p-4 h-100">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane  fade  active show" id="orders" role="tabpanel" aria-labelledby="orders-tab">
                        <h4 class="font-weight-bold mt-0 mb-4">Past Orders</h4>
                        @foreach($orders as $key => $order)
                            <div class="bg-white card mb-4 order-list shadow-sm">
                                <div class="gold-members p-4">
                                    <a href="#"> </a>
                                    <div class="media">
                                        <a href="#"> <img class="mr-4"
                                                          src="{{$order->user()->first()->avatar()}}"
                                                          alt="Generic placeholder image"> </a>
                                        <div class="media-body">
                                            <a href="#"> <span class="float-right text-info">{{$order->created_at}} <i
                                                        class="icofont-check-circled text-success"></i></span> </a>
                                            <h6 class="mb-2"><a href="#"></a>
                                                <a href="#" class="text-black">
                                                    {{$order->client()->first()->fullname}}</a>
                                            </h6>
                                            <p class="text-gray mb-1"><i
                                                    class="icofont-location-arrow"></i> {{$order->address??$order->client->first()->address}}
                                            </p>
                                            <p class="text-gray mb-3"><i class="icofont-list"></i> ORDER
                                                #{{$order->reference}} <i class="icofont-clock-time ml-2"></i> Mon, Nov
                                                12, 6:26 PM</p>
                                            <p class="text-dark">

                                                @foreach($order->product()->get() as $item)
                                                    {{$item['name']}} x {{$item['pivot']['quantity']??null}},
                                                @endforeach
                                            </p>
                                            <hr>
                                            <div class="float-right">
                                                <a class="btn btn-sm btn-outline-primary" href="#"><i
                                                        class="icofont-headphone-alt"></i> @if($order->pagseguro_status=='1')
                                                        Aguardando pagamento
                                                    @elseif($order->pagseguro_status=='2')
                                                        Em análise
                                                    @elseif($order->pagseguro_status=='3')
                                                        Paga
                                                    @elseif($order->pagseguro_status=='4')
                                                        Disponível para saque
                                                    @elseif($order->pagseguro_status=='5')
                                                        Em disputa
                                                    @elseif($order->pagseguro_status=='6')
                                                        Devolvida
                                                    @elseif($order->pagseguro_status=='7')
                                                        Cancelada
                                                    @elseif($order->pagseguro_status=='8')
                                                        Debitado
                                                    @elseif($order->pagseguro_status=='9')
                                                        Retenção temporária
                                                    @endif
                                                </a>
                                                <a class="btn btn-sm btn-primary" href="#"
                                                   onclick="dispatche('{{$order->reference}}');"><i
                                                        class="icofont-refresh"></i> Despachar</a>
                                            </div>
                                            <p class="mb-0 text-black text-primary pt-2"><span
                                                    class="text-black font-weight-bold"> Total Paid:</span>
                                                R$ {{number_format($item['price'] * $item['quantity'], 2, ',', '.')}}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        {{--<div class="bg-white card mb-4 order-list shadow-sm">
                            <div class="gold-members p-4">
                                <a href="#"> </a>
                            </div>
                        </div>
                        <div class="bg-white card  order-list shadow-sm">
                            <div class="gold-members p-4">
                                <a href="#"> </a>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('js')
    <script>
        let dispatche = function (id) {
            axios.post('{{route('ajax.dispatche')}}', {id: id}).then(function (response) {
                location.reload();
            })
        }
    </script>
@endpush
@push('css')
    <style>
        /* My Account */
        .payments-item img.mr-3 {
            width: 47px;
        }

        .order-list .btn {
            border-radius: 2px;
            min-width: 121px;
            font-size: 13px;
            padding: 7px 0 7px 0;
        }

        .osahan-account-page-left .nav-link {
            padding: 18px 20px;
            border: none;
            font-weight: 600;
            color: #535665;
        }

        .osahan-account-page-left .nav-link i {
            width: 28px;
            height: 28px;
            background: #535665;
            display: inline-block;
            text-align: center;
            line-height: 29px;
            font-size: 15px;
            border-radius: 50px;
            margin: 0 7px 0 0px;
            color: #fff;
        }

        .osahan-account-page-left .nav-link.active {
            background: #f3f7f8;
            color: #282c3f !important;
        }

        .osahan-account-page-left .nav-link.active i {
            background: #282c3f !important;
        }

        .osahan-user-media img {
            width: 90px;
        }

        .card offer-card h5.card-title {
            border: 2px dotted #000;
        }

        .card.offer-card h5 {
            border: 1px dotted #daceb7;
            display: inline-table;
            color: #17a2b8;
            margin: 0 0 19px 0;
            font-size: 15px;
            padding: 6px 10px 6px 6px;
            border-radius: 2px;
            background: #fffae6;
            position: relative;
        }

        .card.offer-card h5 img {
            height: 22px;
            object-fit: cover;
            width: 22px;
            margin: 0 8px 0 0;
            border-radius: 2px;
        }

        .card.offer-card h5:after {
            border-left: 4px solid transparent;
            border-right: 4px solid transparent;
            border-bottom: 4px solid #daceb7;
            content: "";
            left: 30px;
            position: absolute;
            bottom: 0;
        }

        .card.offer-card h5:before {
            border-left: 4px solid transparent;
            border-right: 4px solid transparent;
            border-top: 4px solid #daceb7;
            content: "";
            left: 30px;
            position: absolute;
            top: 0;
        }

        .payments-item .media {
            align-items: center;
        }

        .payments-item .media img {
            margin: 0 40px 0 11px !important;
        }

        .reviews-members .media .mr-3 {
            width: 56px;
            height: 56px;
            object-fit: cover;
        }

        .order-list img.mr-4 {
            width: 70px;
            height: 70px;
            object-fit: cover;
            box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075) !important;
            border-radius: 2px;
        }

        .osahan-cart-item p.text-gray.float-right {
            margin: 3px 0 0 0;
            font-size: 12px;
        }

        .osahan-cart-item .food-item {
            vertical-align: bottom;
        }

        .h1, .h2, .h3, .h4, .h5, .h6, h1, h2, h3, h4, h5, h6 {
            color: #000000;
        }

        .shadow-sm {
            box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075) !important;
        }

        .rounded-pill {
            border-radius: 50rem !important;
        }

        a:hover {
            text-decoration: none;
        }
    </style>
@endpush
