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
            proccessPayment(res.card.token, buttonTarget);
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
