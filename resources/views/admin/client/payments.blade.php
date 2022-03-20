@extends('layouts.default')
@section('page-header') Pagamentos @endsection

@section('content')
    <div class="col-lg-12">
        <div class="row">
            <div class="col">
                <div class="card shadow mb-3">
                    <div class="card-header py-3">
                        <a class="btn btn-primary" href="{{route('admin.clients.show',['client'=>$slug])}}">Voltar</a>
                    </div>
                    <div class="card-body">
                        <ul class="ovY-a pos-r scrollable lis-n p-0 m-0 fsz-sm">
                            @foreach($billets as $billet)
                                <li>
                                    <a href="{{$billet['bank_slip']['url_slip']??'#'}}"
                                       class='peers fxw-nw td-n p-20 bdB c-grey-800 cH-blue bgcH-grey-100'
                                       target="_blank">
                                        <input type="hidden" name="notification" id="notification_id">
                                        <div class="peer mR-15">
                                            {{$billet['status']}}
                                        </div>
                                        <div class="peer peer-greed">
                                        <span>
                                            <span class="fw-500">ID: {{$billet['order_id']}}</span>

                                            <span class="c-grey-600">
                                                @foreach($billet['items'] as $item)
                                                    <ul>
                                                     <li>{{$item['description']??''}}</li>
                                                        <li>Qt: {{$item['quantity']??''}}</li>
                                                        <li>R$ {{$item['price_cents']??''}}</li>
                                                    </ul>
                                                @endforeach
                                            </span>
                                        </span>
                                            <p class="m-0">
                                                <small class="fsz-xs">{{$billet['created_at']}}</small>
                                            </p>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
