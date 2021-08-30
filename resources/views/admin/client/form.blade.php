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
                        <div class="form-group string optional  col-md-3"><label
                                class="control-label  optional" for="pessoa_cpf">CPF</label><input
                                class="form-control cpf" type="text" name="cpf"
                                id="pessoa_cpf"
                                placeholder="só números"
                                value="{{old('cpf')}}">
                        </div>

                        <div class="form-group string   pessoa_nome col-md-2"><label
                                class="control-label string  " for="pessoa_nome"><abbr
                                    title=" ">*</abbr> Nome</label><input
                                class="form-control string  " type="text" name="name" value="{{old('name')}}"
                            >
                        </div>
                        <div class="form-group string required   pessoa_nome col-md-4"><label
                                class="control-label string  " for="pessoa_nome"><abbr
                                    title=" ">*</abbr> Sobrenome</label><input
                                class="form-control string  " type="text" name="last_name" value="{{old('last_name')}}"
                            >
                        </div>

                        <div class="form-group select optional pessoa_sexo col-md-3"><label
                                class="control-label select optional" for="pessoa_sexo">Sexo</label><select
                                class="form-control select optional" name="sex" id="pessoa_sexo">
                                <option value=""></option>
                                <option value="m">Masculino</option>
                                <option value="f">Feminino</option>
                            </select></div>

                        <div class="form-group datepicker optional pessoa_data_aniversario col-md-3"><label
                                class="control-label datepicker optional" for="pessoa_data_aniversario">Data de
                                Nascimento</label>
                            <input class="datepicker optional form-control date"
                                   data-date-language="pt_BR" type="text"
                                   name="birth_date"
                                   id="pessoa_data_aniversario"
                                   value="{{old('birth_date')}}">
                        </div>
                        <div class="form-group email optional pessoa_email col-md-5"><label
                                class="control-label email optional" for="pessoa_email">E-mail</label><input
                                class="form-control string email optional" type="email" name="email"
                                id="pessoa_email"
                                value="{{old('email')}}">
                        </div>
                        <div class="form-group string optional pessoa_telefone col-md-3"><label
                                class="control-label string optional" for="pessoa_telefone">Telefone</label><input
                                class="form-control string optional tel" type="text" name="tel0"
                                id="pessoa_telefone"
                                value="{{old('tel0')}}">
                        </div>

                    </div>
                </fieldset>

                <fieldset class="col-md-12">
                    <legend>Endereço</legend>
                    <!-- <legend>Endereço <a href="javascript:void(0)" class="fieldset-handler">mostrar</a></legend> -->
                    <div class="row">
                        <!-- <div class="fieldset-container fieldset-handler-target"> -->
                        <div class="form-group string optional pessoa_cep col-md-3"><label
                                class="control-label string optional" for="pessoa_cep">Cep</label><input
                                class="form-control string optional cep" placeholder="Digite o CEP" type="text"
                                name="cep" id="pessoa_cep"
                                value="{{old('cep')}}"
                            >
                        </div>
                        <div class="form-group string optional pessoa_logradouro col-md-7"><label
                                class="control-label string optional"
                                for="pessoa_logradouro">Logradouro</label><input
                                class="form-control string optional transform-upper-case"
                                oninput="RemoveAccents(this, this.value)" type="text" name="address"
                                value="{{old('address')}}"
                                id="pessoa_logradouro">
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
                                id="pessoa_bairro">
                        </div>
                        <div class="form-group string optional pessoa_cidade col-md-3"><label
                                class="control-label string optional" for="pessoa_cidade">Cidade</label><input
                                class="form-control string optional transform-upper-case"
                                oninput="RemoveAccents(this, this.value)" type="text" name="city"
                                value="{{old('city')}}"
                                id="pessoa_cidade">
                        </div>
                        <div class="form-group string optional pessoa_uf col-md-2"><label
                                class="control-label string optional" for="pessoa_uf">UF</label><input
                                class="form-control string optional transform-upper-case"
                                oninput="RemoveAccents(this, this.value)" type="text" name="state"
                                value="{{old('state')}}"
                                id="pessoa_uf">
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
