@extends('layouts.default')
@section('title', 'Funcionários')
@section('page-header')Funcionário @endsection
@section('content')
    <div class="row mB-40">
        <div class="col-sm-8">
            <div class="bgc-white p-20 bd">
                {!! Form::open($form) !!}

                <input type="hidden" name="id" value="{{ $employee->id??'' }}">

                <fieldset class="col-md-12">
                    <legend>Dados Principais</legend>
                    <div class="row">
                        <x-form-input name="cpf" title="CPF" class="optional col-md-3" inputClass="cpf"
                                      placeholder="só numeros" :value="$employee->cpf??''"></x-form-input>
                        <x-form-input name="name" title="Nome" :value="$employee['name']??''" class="col-md-2"
                                      required></x-form-input>
                        <x-form-input name="last_name" title="Sobrenome" :value="$employee->last_name??''"
                                      class="col-md-4"
                                      required></x-form-input>
                        @php($selects=[['value'=>'m','name'=>'Masculino'],['value'=>'f','name'=>'Feminino']])
                        <x-form-select :selects="$selects" name="sex" title="Sexo"></x-form-select>
                        <x-form-date class="col-md-3" name="birth_date" title="Data de Nascimento"
                                     :value="$employee->birth_date??''"></x-form-date>
                        <x-form-input type="email" class="col-md-5 email" name="email" title="E-mail" inputClass="email"
                                      :value="$employee->email??''"></x-form-input>
                        <x-form-input class="col-md-3" title="Telefone" name="tel0" inputClass="tel"
                                      :value="$employee->tel0??''"></x-form-input>

                    </div>
                </fieldset>

                @if($form['route'][0]=='admin.employee.store')
                    <fieldset class="col-md-12">
                        <legend>Acesso</legend>
                        <div class="row">


                            <x-form-input name="password" title="Password" type="password"
                                          class="col-md-2"></x-form-input>
                            <x-form-input type="password" name="password_confirmation"
                                          title="Password again"></x-form-input>
                        </div>
                    </fieldset>
                @endif

                <fieldset class="col-md-12">
                    <legend>Endereço</legend>
                    <!-- <legend>Endereço <a href="javascript:void(0)" class="fieldset-handler">mostrar</a></legend> -->
                    <div class="row">
                        <!-- <div class="fieldset-container fieldset-handler-target"> -->
                        <x-form-input class="col-md-3 " title="Cep" placeholder="Digite o CEP" name="cep"
                                      value="{{$employee->cep??old('cep')}}"
                                      inputClass="cep"></x-form-input>

                        <div class="form-group string optional pessoa_logradouro col-md-7"><label
                                class="control-label string optional"
                                for="pessoa_logradouro">Logradouro</label><input
                                class="form-control string optional transform-upper-case"
                                oninput="RemoveAccents(this, this.value)" type="text" name="address"
                                value="{{$employee->address??old('address')}}"
                                id="Street">
                        </div>
                        <div class="form-group integer optional pessoa_numero col-md-2"><label
                                class="control-label integer optional" for="pessoa_numero">Número</label><input
                                class="form-control numeric integer optional" type="number" step="1"
                                value="{{$employee->number??old('number')}}"
                                name="number" id="pessoa_numero">
                        </div>

                        <div class="form-group string optional pessoa_complemento col-md-4"><label
                                class="control-label string optional"
                                for="pessoa_complemento">Complemento</label><input
                                class="form-control string optional" type="text" name="complement"
                                value="{{$employee->complement??old('complement')}}"
                                id="pessoa_complemento"></div>

                        <div class="form-group string optional pessoa_bairro col-md-3"><label
                                class="control-label string optional" for="pessoa_bairro">Bairro</label><input
                                class="form-control string optional transform-upper-case"
                                oninput="RemoveAccents(this, this.value)" type="text" name="district"
                                value="{{$employee->district??old('district')}}"
                                id="District">
                        </div>
                        <div class="form-group string optional pessoa_cidade col-md-3"><label
                                class="control-label string optional" for="pessoa_cidade">Cidade</label><input
                                class="form-control string optional transform-upper-case"
                                oninput="RemoveAccents(this, this.value)" type="text" name="city"
                                value="{{$employee->city??old('city')}}"
                                id="City">
                        </div>
                        <div class="form-group string optional pessoa_uf col-md-2"><label
                                class="control-label string optional" for="pessoa_uf">UF</label><input
                                class="form-control string optional transform-upper-case"
                                oninput="RemoveAccents(this, this.value)" type="text" name="state"
                                value="{{$employee->state??old('state')}}"
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
