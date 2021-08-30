@extends('layouts.front')
@section('content')
    <h1 class="mt-5">Stripe.js v3 with Bootstrap 4 (beta) Test</h1>
    <div id="card-errors" role="alert"></div>
    <div class="card">
        <div class="card-body">
            <form id="payment-form">
                <label for="name">Name on Card</label>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text">A</span>
                    </div>
                    <input type="text" class="form-control" id="name">
                    <div class="input-group-append">
                        <span class="input-group-text">B</span>
                    </div>
                </div>
                <label for="card-number">Credit Card Number</label>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text">C</span>
                    </div>
                    <span id="card-number" class="form-control">
                            <!-- Stripe Card Element -->
                        </span>
                    <div class="input-group-append">
                        <span class="input-group-text">D</span>
                    </div>
                </div>
                <label for="card-cvc">CVC Number</label>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text">E</span>
                    </div>
                    <span id="card-cvc" class="form-control">
                            <!-- Stripe CVC Element -->
                        </span>
                </div>
                <label for="card-exp">Expiration</label>
                <div class="input-group mb-2">
                        <span id="card-exp" class="form-control">
                            <!-- Stripe Card Expiry Element -->
                        </span>
                    <div class="input-group-append">
                        <span class="input-group-text">F</span>
                    </div>
                </div>
                <button id="payment-submit" class="btn btn-primary mt-1">Submit Payment</button>
            </form>
        </div>
    </div>
@endsection
@push('js')
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"
            integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
            crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
            crossorigin="anonymous"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        $(document).ready(function () {

            // Create a Stripe client
            var stripe = Stripe('pk_test_XxXxXxXxXxXxXxXxXxXxXxXx');

            // Create an instance of Elements
            var elements = stripe.elements();

            // Try to match bootstrap 4 styling
            var style = {
                base: {
                    'lineHeight': '1.35',
                    'fontSize': '1.11rem',
                    'color': '#495057',
                    'fontFamily': 'apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif'
                }
            };

            // Card number
            var card = elements.create('cardNumber', {
                'placeholder': '',
                'style': style
            });
            card.mount('#card-number');

            // CVC
            var cvc = elements.create('cardCvc', {
                'placeholder': '',
                'style': style
            });
            cvc.mount('#card-cvc');

            // Card expiry
            var exp = elements.create('cardExpiry', {
                'placeholder': '',
                'style': style
            });
            exp.mount('#card-exp');

            // Submit
            $('#payment-submit').on('click', function (e) {
                e.preventDefault();
                var cardData = {
                    'name': $('#name').val()
                };
                stripe.createToken(card, cardData).then(function (result) {
                    console.log(result);
                    if (result.error && result.error.message) {
                        alert(result.error.message);
                    } else {
                        alert(result.token.id);
                    }
                });
            });

        });
    </script>
@endpush
