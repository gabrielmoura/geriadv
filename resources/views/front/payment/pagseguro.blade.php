@extends('layouts.front')
@section('content')
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <a class="nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab"
               aria-controls="nav-home" aria-selected="true">Cartão de crédito</a>
            <a class="nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab"
               aria-controls="nav-profile" aria-selected="false">Boleto</a>

        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-12 msg">

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h2>Dados para Pagamento</h2>
                        <hr>
                    </div>
                </div>
                {!! Form::open($form) !!}
                <input type="hidden" name="payment" value="cc">

                <div class="row">
                    <div class="col-md-12 form-group">
                        <label>Nome no Cartão</label>
                        <input type="text" class="form-control" name="card_name">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 form-group">
                        <label>Número do Cartão <span class="brand"></span></label>
                        <input type="text" class="form-control" name="card_number">
                        <input type="hidden" name="card_brand">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 form-group">
                        <label>Mês de Expiração</label>
                        <input type="text" class="form-control" name="card_month">
                    </div>

                    <div class="col-md-4 form-group">
                        <label>Ano de Expiração</label>
                        <input type="text" class="form-control" name="card_year">
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-5 form-group">
                        <label>Código de Segurança</label>
                        <input type="text" class="form-control" name="card_cvv">
                    </div>

                    <div class="col-md-12 installments form-group"></div>
                </div>

                <button class="btn btn-success btn-lg processCheckout">Efetuar Pagamento</button>
                {!! Form::close() !!}
            </div>
        </div>
        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-12 msg">

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h2>Dados para Pagamento</h2>
                        <hr>
                    </div>
                </div>
                <p>Valor: {{$cartItems}}</p>

                {!! Form::open($form) !!}
                <input type="hidden" name="payment" value="boleto">
                <input type="hidden" name="hash" id="hashB" value="0">
                <button class="btn btn-success btn-lg processCheckout">Gerar Boleto</button>
                {!! Form::close() !!}

            </div>

        </div>
    </div>
@endsection
@push('js')
    <script type="text/javascript" src="{{ PagSeguro::getUrl()['javascript'] }}"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        const sessionId = '{{session()->get('pagseguro_session_code')}}';
        const urlThanks = '{{route('checkout.thanks')}}';
        const urlProccess = '{{route("checkout.proccess")}}';
        const amoutTransaction = '{{$cartItems}}';
        const csrf = '{{csrf_token()}}';

        PagSeguroDirectPayment.setSessionId(sessionId);
        window.onload = function() {
            let hash = PagSeguroDirectPayment.getSenderHash();
            //document.getElementById('hashCC').value = hash;
            document.getElementById('hashB').value = hash;
        };
    </script>
    <script >
        let cardNumber = document.querySelector('input[name=card_number]');
        let spanBrand  = document.querySelector('span.brand');

        cardNumber.addEventListener('keyup', function(){
            if(cardNumber.value.length >= 6) {
                PagSeguroDirectPayment.getBrand({
                    cardBin: cardNumber.value.substr(0, 6),
                    success: function(res) {
                        let imgFlag = `<img src="https://stc.pagseguro.uol.com.br/public/img/payment-methods-flags/68x30/${res.brand.name}.png">`;
                        spanBrand.innerHTML = imgFlag;
                        document.querySelector('input[name=card_brand]').value = res.brand.name;

                        getInstallments(amoutTransaction, res.brand.name);
                    },
                    error: function(err) {
                        console.log(err);
                    },
                    complete: function(res) {
                        //console.log('Complete', res);
                    }
                });
            }
        });

        let submitButton = document.querySelector('button.processCheckout');

        submitButton.addEventListener('click', function(event){
            event.preventDefault();
            document.querySelector('div.msg').innerHTML = '';

            let buttonTarget = event.target;

            buttonTarget.disabled = true;
            buttonTarget.innerHTML = 'Carregando...';

            PagSeguroDirectPayment.createCardToken({
                cardNumber: document.querySelector('input[name=card_number]').value,
                brand:      document.querySelector('input[name=card_brand]').value,
                cvv:        document.querySelector('input[name=card_cvv]').value,
                expirationMonth: document.querySelector('input[name=card_month]').value,
                expirationYear:  document.querySelector('input[name=card_year]').value,
                success: function(res) {
                    document.getElementById('card_token').value=res.card.token
                    //proccessPayment(res.card.token, buttonTarget);
                },
                error: function(err) {
                    buttonTarget.disabled = false;
                    buttonTarget.innerHTML = 'Efetuar Pagamento';

                    for(let i in err.errors) {
                        document.querySelector('div.msg').innerHTML = showErrorMessages(errorsMapPagseguroJS(i));
                    }
                }
            });
        });
        function proccessPayment(token, buttonTarget) {
            let data = {
                card_token: token,
                hash: document.getElementById('hashCC').value,
                installment: document.querySelector('select.select_installments').value,
                card_name: document.querySelector('input[name=card_name]').value
            };
            axios.post(urlProccess, {data: data}).then(function (res) {
                toastr.success(res.data.message, 'Sucesso');
                window.location.href = `${urlThanks}?order=${res.data.order}`;
            }).catch(function (res) {
                buttonTarget.disabled = false;
                buttonTarget.innerHTML = 'Efetuar Pagamento';

                let message = JSON.parse(err.responseText);
                document.querySelector('div.msg').innerHTML = showErrorMessages(message.data.message.error.message);
            });


        }


        function getInstallments(amount, brand) {
            PagSeguroDirectPayment.getInstallments({
                amount: amount,
                brand: brand,
                maxInstallmentNoInterest: 0,
                success: function (res) {
                    let selectInstallments = drawSelectInstallments(res.installments[brand]);
                    document.querySelector('div.installments').innerHTML = selectInstallments;
                },
                error: function (err) {
                    console.log(err);
                },
                complete: function (res) {

                },
            })
        }

        function drawSelectInstallments(installments) {
            let select = '<label>Opções de Parcelamento:</label>';

            select += '<select class="form-control select_installments">';

            for (let l of installments) {
                select += `<option value="${l.quantity}|${l.installmentAmount}">${l.quantity}x de ${l.installmentAmount} - Total fica ${l.totalAmount}</option>`;
            }

            select += '</select>';

            return select;
        }

        function showErrorMessages(message) {
            return `
        <div class="alert alert-danger">${message}</div>
    `;
        }

        function errorsMapPagseguroJS(code) {
            switch (code) {
                case "10000":
                    return 'Bandeira do cartão inválida!';
                    break;

                case "10001":
                    return 'Número do Cartão com tamanho inválido!';
                    break;

                case "10002":
                case  "30405":
                    return 'Data com formato inválido!';
                    break;

                case "10003":
                    return 'Código de segurança inválido';
                    break;

                case "10004":
                    return 'Código de segurança é obrigatório!';
                    break;

                case "10006":
                    return 'Tamanho do código de segurança inválido!';
                    break;

                default:
                    return 'Houve um erro na validação do seu cartão de crédito!';
            }
        }

    </script>
@endpush
@push('css')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endpush
