@extends('layouts.default')
@section('page-header')Cliente @endsection
@section('content')
    <div class="row mB-40">
        <div class="col-sm-8">
            <div class="bgc-white p-20 bd">
                {!! Form::open($form) !!}


                <fieldset class="col-md-12">
                    <legend>Dados Principais</legend>
                    <div class="row">
                        <x-form-input name="cpf" title="CPF" class="optional col-md-3"
                                      placeholder="só numeros"></x-form-input>
                        <x-form-input name="name" title="Nome" class="col-md-2" required></x-form-input>
                        <x-form-input name="last_name" title="Sobrenome" class="col-md-4" required></x-form-input>
                        @php($selects=[['value'=>'m','name'=>'Masculino'],['value'=>'f','name'=>'Feminino']])
                        <x-form-select :selects="$selects" name="sex" title="Sexo"></x-form-select>
                        <x-form-date class="col-md-3" name="birth_date" title="Data de Nascimento"></x-form-date>
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

                <fieldset class="col-md-12">
                    <legend>Informações Adicionais</legend>
                    <div class="row">
                        <div class="form-group string optional pessoa_profissao col-xs-6"><label
                                class="control-label string optional" for="pessoa_profissao">Profissao</label><input
                                class="form-control string optional" rows="3" type="text" name="pessoa[profissao]"
                                id="pessoa_profissao"></div>
                        <div class="form-group file optional pessoa_foto col-md-6"><label
                                class="control-label file optional" for="pessoa_foto">Foto</label><input
                                class="file optional" type="file" name="pessoa[foto]" id="pessoa_foto"></div>

                    </div>
                    <div class="row">
                        <div class="form-group text optional pessoa_anotacoes col-xs-12 col-md-12"><label
                                class="control-label text optional"
                                for="pessoa_anotacoes">Anotacoes</label><textarea class="form-control text optional"
                                                                                  rows="3" name="note"
                                                                                  id="pessoa_anotacoes"></textarea>
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
