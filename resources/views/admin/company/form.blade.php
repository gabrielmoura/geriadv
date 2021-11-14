@extends('layouts.default')
@section('page-header')Cadastrar Empresa @endsection
@section('content')
    <div class="row mB-40">
        <div class="col-sm-8">
            <div class="bgc-white p-20 bd">
                {!! Form::open($form) !!}

                <fieldset class="col-md-12">
                    <legend>Dados Principais</legend>
                    <div class="row">
                        <x-form-input name="cnpj" title="CNPJ" class="optional col-md-3" inputClass="cnpj"
                                      placeholder="só numeros"></x-form-input>
                        <x-form-input name="name" title="Nome" class="col-md-2" required></x-form-input>
                        <x-form-input type="email" class="col-md-5 email" name="email" title="E-mail"></x-form-input>
                        <x-form-input class="col-md-3" title="Telefone" name="tel0" inputClass="tel"></x-form-input>

                    </div>
                </fieldset>


                <fieldset class="col-md-12">
                    <legend>Endereço</legend>
                    <!-- <legend>Endereço <a href="javascript:void(0)" class="fieldset-handler">mostrar</a></legend> -->
                    <div class="row">
                        <!-- <div class="fieldset-container fieldset-handler-target"> -->
                        <x-form-input class="col-md-3 " title="Cep" placeholder="Digite o CEP" name="cep"
                                      inputClass="cep"></x-form-input>

                        <div class="form-group string optional pessoa_logradouro col-md-7"><label
                                class="control-label string optional"
                                for="pessoa_logradouro">Logradouro</label><input
                                class="form-control string optional transform-upper-case"
                                oninput="RemoveAccents(this, this.value)" type="text" name="address"
                                value="{{old('address')}}"
                                id="Street">
                        </div>
                        <div class="form-group integer optional pessoa_numero col-md-2"><label
                                class="control-label integer optional" for="pessoa_numero">Número</label><input
                                class="form-control numeric integer optional" type="number" step="1"
                                value="{{old('number')}}"
                                name="number" id="pessoa_numero">
                        </div>

                        <div class="form-group string optional pessoa_complemento col-md-4"><label
                                class="control-label string optional"
                                for="pessoa_complemento">Complemento</label><input
                                class="form-control string optional" type="text" name="complement"
                                value="{{old('complement')}}"
                                id="pessoa_complemento"></div>

                        <div class="form-group string optional pessoa_bairro col-md-3"><label
                                class="control-label string optional" for="pessoa_bairro">Bairro</label><input
                                class="form-control string optional transform-upper-case"
                                oninput="RemoveAccents(this, this.value)" type="text" name="district"
                                value="{{old('district')}}"
                                id="District">
                        </div>
                        <div class="form-group string optional pessoa_cidade col-md-3"><label
                                class="control-label string optional" for="pessoa_cidade">Cidade</label><input
                                class="form-control string optional transform-upper-case"
                                oninput="RemoveAccents(this, this.value)" type="text" name="city"
                                value="{{old('city')}}"
                                id="City">
                        </div>
                        <div class="form-group string optional pessoa_uf col-md-2"><label
                                class="control-label string optional" for="pessoa_uf">UF</label><input
                                class="form-control string optional transform-upper-case"
                                oninput="RemoveAccents(this, this.value)" type="text" name="state"
                                value="{{old('state')}}"
                                id="State">
                        </div>
                    </div>
                </fieldset>



                <button type="submit" class="btn btn-primary">Salvar</button>

                {!! Form::close() !!}
            </div>
        </div>

    </div>
@endsection
@push('js')
    <script>
        document.getElementById('Cep').onmouseout = function () {
            mclients.getCep(document.getElementById('Cep').value);
        };
    </script>
@endpush
