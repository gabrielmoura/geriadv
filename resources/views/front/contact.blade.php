
<section class="bg-light-gray" id="form" style="background-color: #ececec;">
    <div class="container">
        <div class="row">
            <div class="col-lg-7">

                <div class="section-heading">
                    <h3 class="font-weight-600">Entre em contato com a gente</h3>
                </div>

                <p class="margin-30px-bottom sm-margin-20px-bottom">Tem alguma dúvida? Gostaria de mais alguma informação? Entre em contato conosco.</p>
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="inner-box bg-white box-shadow-large padding-20px-all md-padding-15px-all sm-margin-20px-bottom">
                            <div class="icon-box display-inline-block margin-20px-right md-margin-15px-right vertical-align-top border-right padding-20px-right md-padding-15px-right">
                                <span class=" icon-envelope text-theme-color font-size32 md-font-size26 xs-font-size24"></span>
                            </div>
                            <div class="inner-text display-inline-block">
                                <h3 class="font-size18 sm-font-size16 sm-font-size15 no-margin">E-mail</h3>
                                <p class="no-margin" style="font-size: 13px;">contato@oassessor.com.br</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="inner-box bg-white  box-shadow-large  padding-20px-all md-padding-15px-all sm-margin-20px-bottom">
                            <div class="icon-box display-inline-block margin-20px-right md-margin-15px-right vertical-align-top border-right padding-20px-right md-padding-15px-right">
                                <span class="icon-phone text-theme-color font-size32 md-font-size26 xs-font-size24"></span>
                            </div>
                            <div class="inner-text display-inline-block">
                                <h3 class="font-size18 sm-font-size16 sm-font-size15 no-margin">Telefone</h3>
                                <p class="no-margin" style="font-size: 13px;">(11) 3164-1591</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 padding-70px-left sm-padding-15px-left">
                <div class="contact-form-box bg-white box-shadow-primary padding-20px-all border-radius-5 padding-30px-all">
                    <h4 class="font-weight-600 font-size18 xs-font-size16">Envie uma mensagem</h4>



                    <form method="POST" action="{{route('message.contact')}}" accept-charset="UTF-8" data-grecaptcha-action="contact">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <input placeholder="Seu nome:" data-constraints="@LettersOnly  @NotEmpty" name="name" type="text">

                            </div>
                            <div class="col-md-12">
                                <input placeholder="Telefone:" data-constraints="@Phone" name="tel" type="text">

                            </div>
                            <div class="col-md-12">

                                <input placeholder="E-mail" data-constraints="@Email  @NotEmpty" name="email" type="email">
                            </div>
                            <div class="col-md-12">

                                <textarea placeholder="mensagem" data-constraints="@NotEmpty" rows="2" name="mensagem" cols="50"></textarea>
                            </div>


                            <div class="mfControls col-md-12">
                                <button type="submit" id="input-submit" class="butn small">Enviar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@push('head')
    <meta name="grecaptcha-key" content="{{config('recaptcha.v3.public_key')}}">
    <script src="https://www.google.com/recaptcha/api.js?render={{config('recaptcha.v3.public_key')}}"></script>
@endpush
@push('js')
    <script src="{{asset('js/front/recaptcha.js')}}"></script>
@endpush
