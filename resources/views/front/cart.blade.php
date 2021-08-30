@extends('layouts.front')
@section('content')
    <div class="row">
        <div class="col-12">
            <h2>Carrinho de Compras</h2>
            <hr>
        </div>
        <div class="col-12">
            @if($cart)
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Imagem</th>
                        <th>Produto</th>
                        <th>Preço</th>
                        <th>Quantidade</th>
                        <th>Subtotal</th>
                        <th>Ação</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php $total = 0; @endphp

                    @foreach($cart as $i=>$c)
                        <tr>

                            <td>
                                <img style="max-width: 50px" src="{{$c->associatedModel->thumb}}">
                            </td>
                            <td>
                                <a href="{{route('product.single',['slug'=>$c->associatedModel->slug])}}">{{$c['name']}}</a>
                            </td>
                            <td>R$ <span id="price">{{number_format($c['price'], 2, ',', '.')}}</span></td>
                            <span style="display: none;" id="rawPrice{{$i}}">{{$c['price']}}</span>
                            <td>
                                <a href="#" onclick="incrementCart('{{$c['id']}}','{{$i}}');">
                                    <i class="fa fa-caret-square-o-up fa-lg"></i>
                                </a>
                                <span id="quantity{{$i}}">{{$c['quantity']}}</span>
                                <a href="#" onclick="decrementCart('{{$c['id']}}','{{$i}}');">
                                    <i class="fa fa-caret-square-o-down fa-lg"></i>
                                </a>
                            </td>
                            @php
                                $subtotal=$c['price']*$c['quantity']
                            @endphp
                            <td>R$ <span id="subtotal{{$i}}">{{$subtotal}}</span></td>
                            <td>
                                <a href="{{route('cart.remove', ['slug' => $c['id']])}}" class="btn btn-sm btn-danger">REMOVER</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <hr>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Endereço</th>
                        <th>Prazo (dias)</th>
                        <th>Preço</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td id="address"></td>
                        <td id="deadline"></td>
                        <td id="price"></td>
                    </tr>
                    <tr>
                        <td colspan="3">Total:</td>
                        <td colspan="2" id="valor"></td>
                    </tr>
                    </tbody>
                </table>
                <hr>
                @if(!is_object($cart->get('Frete')))
                    <div class="row g-2">
                        <div class="col-auto">
                            <input type="text" class="form-control" id="cep" placeholder="CEP">
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary mb-3" onclick="getCep();">Calcular Frete
                            </button>
                        </div>
                    </div>
                    <input id="frete" type="hidden" value="false">
                @else
                    <input id="frete" type="hidden" value="true">
                @endif
                <div class="col-md-12">
                    <a onclick="goCheckout();" class="btn btn-lg btn-success float-right">Concluir Compra</a>

                    <a href="{{route('cart.cancel')}}" class="btn btn-lg btn-danger float-left">Cancelar Compra</a>

                </div>
            @else
                <div class="alert alert-warning">Carrinho vazio...</div>
            @endif
        </div>
    </div>
@endsection
@push('js')
    <script>
        var getCep = function () {
            cep = document.getElementById('cep').value;
            uri = '{{route('ajax.getCep')}}';
            axios.post(uri, {cep: cep}).then(function (response) {
                document.querySelector('#address').innerHTML = response.data.logradouro;
                getTracking(cep);
            });
        }, getTracking = function (cep) {
            uri = '{{route('ajax.getFrete')}}';
            axios.post(uri, {cep_destino: cep}).then(function (response) {
                document.querySelector('#price').innerHTML = response.data[0].valor;
                document.querySelector('#deadline').innerHTML = response.data[0].prazo;
                getTotal(response.data[0].valor);
            });
        }, getTotal = function (valor) {
            subtotal = {{$total}};
            total = subtotal + valor;
            document.querySelector('#valor').innerHTML = 'R$ ' + total;
        }, goCheckout = function () {
            href = "{{route('checkout.index')}}";
            if (document.getElementById('frete').value) {
                window.location.replace(href);
            }
            if (!!document.querySelector('#price').innerText) {
                window.location.replace(href);
                /* axios.post('{{route('ajax.addFrete')}}', {
                    logradouro: document.querySelector('#address').innerText,
                    price: document.querySelector('#price').innerText
                }).then(function (response) {
                    window.location.replace(href);
                });*/
            } else {
                document.getElementById('cep').focus();
            }
        }, incrementCart = function (id, index) {
            quantity = document.getElementById('quantity' + index);
            quantity.textContent++
            axios.post('{{route('ajax.quantityCart')}}', {
                id: id,
                quantity: quantity.textContent
            }).then(function (response) {
                price = document.getElementById('rawPrice' + index);
                subtotal = document.getElementById('subtotal' + index);
                nSubTotal = quantity.textContent * price.textContent;
                subtotal.textContent = nSubTotal.toLocaleString('pt-BR');

            });

        }, decrementCart = function (id, index) {
            quantity = document.getElementById('quantity' + index);
            quantity.textContent--
            axios.post('{{route('ajax.quantityCart')}}', {
                id: id,
                quantity: quantity.textContent
            }).then(function (response) {
                price = document.getElementById('rawPrice' + index);
                subtotal = document.getElementById('subtotal' + index);
                nSubTotal = quantity.textContent * price.textContent;
                subtotal.textContent = nSubTotal.toLocaleString('pt-BR');
                // new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(quantity.textContent * price.textContent)

            });
        };
    </script>
@endpush
