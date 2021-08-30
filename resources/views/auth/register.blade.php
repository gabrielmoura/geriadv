@extends('layouts.front')

@section('content')
    <section class="account-login-area">
        <div class="container">
            <div class="row">
                <h4 class="fw-300 c-grey-900 mB-40">Registro</h4>
                <form method="POST" action="{{ route('register') }}">
                    {{ csrf_field() }}
                    <div>

                        <h5 class="fw-300 c-grey-900 mB-40">Dados Pessoais</h5>

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="text-normal text-dark">NickName</label>
                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}"
                                   required
                                   autofocus>

                            @if ($errors->has('name'))
                                <span class="form-text text-danger">
                    <small>{{ $errors->first('name') }}</small>
                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('realname') ? ' has-error' : '' }}">
                            <label for="realname" class="text-normal text-dark">Nome</label>
                            <input id="realname" type="text" class="form-control" name="realname"
                                   value="{{ old('realname') }}"
                                   required
                                   autofocus>

                            @if ($errors->has('realname'))
                                <span class="form-text text-danger">
                    <small>{{ $errors->first('realname') }}</small>
                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                            <label for="last_name" class="text-normal text-dark">Sobrenome</label>
                            <input id="last_name" type="text" class="form-control" name="last_name"
                                   value="{{ old('last_name') }}"
                                   required
                                   autofocus>

                            @if ($errors->has('last_name'))
                                <span class="form-text text-danger">
                    <small>{{ $errors->first('last_name') }}</small>
                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="text-normal text-dark">Email</label>
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}"
                                   required>

                            @if ($errors->has('email'))
                                <span class="form-text text-danger">
                    <small>{{ $errors->first('email') }}</small>
                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('tel') ? ' has-error' : '' }}">
                            <label for="tel" class="text-normal text-dark">Telefone</label>
                            <input id="tel" type="text" class="form-control tel" name="tel" value="{{ old('tel') }}"
                                   required>

                            @if ($errors->has('tel'))
                                <span class="form-text text-danger">
                    <small>{{ $errors->first('tel') }}</small>
                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('doc') ? ' has-error' : '' }}">
                            <label for="doc" class="text-normal text-dark" id="labelDoc">Documento</label>
                            <input id="doc" type="text" class="form-control cpf" name="doc" value="{{ old('doc') }}"
                                   required autofocus>

                            @if ($errors->has('doc'))
                                <span class="form-text text-danger">
                    <small>{{ $errors->first('doc') }}</small>
                </span>
                            @endif
                        </div>
                        {!! Form::mySelect('sex','Sexo',['m'=>'Masculino','f'=>'Feminino'],old('sex')) !!}

                        <div class="form-group{{ $errors->has('birth_date') ? ' has-error' : '' }}">
                            <label for="birth_date" class="text-normal text-dark" id="labelDoc">Data de
                                Nascimento</label>
                            <input id="birth_date" type="date" class="form-control" name="birth_date"
                                   value="{{ old('birth_date') }}"
                                   required autofocus>

                            @if ($errors->has('birth_date'))
                                <span class="form-text text-danger">
                    <small>{{ $errors->first('birth_date') }}</small>
                </span>
                            @endif
                        </div>


                    </div>
                    <div>
                        <h5 class="fw-300 c-grey-900 mB-40">Dados do Endereço</h5>

                        <div class="form-group{{ $errors->has('cep') ? ' has-error' : '' }}">
                            <label for="cep" class="text-normal text-dark">CEP</label>
                            <input id="cep" type="text" class="form-control cep" name="cep" value="{{ old('cep') }}"
                                   required autofocus>

                            @if ($errors->has('cep'))
                                <span class="form-text text-danger">
                    <small>{{ $errors->first('cep') }}</small>
                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                            <label for="address" class="text-normal text-dark">Endereço</label>
                            <input id="address" type="text" class="form-control" name="address"
                                   value="{{ old('address') }}"
                                   required autofocus>

                            @if ($errors->has('address'))
                                <span class="form-text text-danger">
                    <small>{{ $errors->first('address') }}</small>
                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('number') ? ' has-error' : '' }}">
                            <label for="address" class="text-normal text-dark">Numero</label>
                            <input id="number" type="number" class="form-control" name="number"
                                   value="{{ old('number') }}"
                                   required autofocus>

                            @if ($errors->has('number'))
                                <span class="form-text text-danger">
                    <small>{{ $errors->first('number') }}</small>
                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('complement') ? ' has-error' : '' }}">
                            <label for="complement" class="text-normal text-dark">Complemento</label>
                            <input id="complement" type="text" class="form-control" name="complement"
                                   value="{{ old('complement') }}"
                                   required autofocus>

                            @if ($errors->has('complement'))
                                <span class="form-text text-danger">
                    <small>{{ $errors->first('complement') }}</small>
                </span>
                            @endif
                        </div>


                        <div class="form-group{{ $errors->has('district') ? ' has-error' : '' }}">
                            <label for="district" class="text-normal text-dark">Bairro</label>
                            <input id="district" type="text" class="form-control" name="district"
                                   value="{{ old('district') }}"
                                   required autofocus>

                            @if ($errors->has('district'))
                                <span class="form-text text-danger">
                    <small>{{ $errors->first('district') }}</small>
                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                            <label for="city" class="text-normal text-dark">Cidade</label>
                            <input id="city" type="text" class="form-control" name="city" value="{{ old('city') }}"
                                   required autofocus>

                            @if ($errors->has('city'))
                                <span class="form-text text-danger">
                    <small>{{ $errors->first('city') }}</small>
                </span>
                            @endif
                        </div>

                        {!! Form::mySelect('state','Estado',(new \App\Actions\Payment\StateCity())->state(),old('state')) !!}


                    </div>


                    <div>
                        <h5 class="fw-300 c-grey-900 mB-40">Senha para acesso</h5>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="text-normal text-dark">password</label>
                            <input id="password" type="password" class="form-control" name="password" required>

                            @if ($errors->has('password'))
                                <span class="form-text text-danger">
                    <small>{{ $errors->first('password') }}</small>
                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation" class="text-normal text-dark">Confirm Password</label>
                            <input id="password_confirmation" type="password" class="form-control"
                                   name="password_confirmation"
                                   required>

                        </div>
                    </div>

                    <span>Ao se registrar estará aceitando nossa <a
                            href="{{route('document.single',['slug'=>'politica-de-privacidade'])}}">Politica de Privacidade</a></span>
                    <br>
                    <div class="form-group">
                        <div class="peers ai-c jc-sb fxw-nw">
                            <div class="peer">
                                <a href="{{route('login')}}">Eu tenho uma conta</a>
                            </div>
                            <div class="peer">
                                <button class="btn btn-primary">Registrar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
@push('js')
    <script>
        $("#cep").change(function () {
            var cep_code = $(this).val();
            if (cep_code.length <= 8) return;
            axios.post("{{route('ajax.getCep')}}", {cep: cep_code})
                .then(function (response) {
                    $("input#cep").val(response.data.cep);
                    $("input#estado").val(response.data.uf);
                    $("input#city").val(response.data.localidade);
                    $("input#district").val(response.data.bairro);
                    $("input#address").val(response.data.logradouro);
                    $("input#state").val(response.data.uf);
                });
        });
    </script>
@endpush
