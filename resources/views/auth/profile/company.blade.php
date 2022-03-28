@extends('layouts.default')

@section('content')
    <div class="container-fluid">
        <h3 class="text-dark mb-4">{{$company->name}}</h3>
        <div class="row mb-3">

            <div class="col-lg-4">
                <div class="card mb-3">
                    <div class="card-body text-center shadow">
                        <img class="rounded-circle mb-3 mt-4"
                             src="{{$company->logo??'https://ui-avatars.com/api/?rounded=true&name='.$company->name}}"
                             width="160" height="160"/>

                        <div class="mb-3">
                            <a class="btn btn-info" data-toggle="modal" data-target="#LogoModal">Editar</a>
                            <!--<button class="btn btn-primary btn-sm" type="button">Change Photo</button>-->
                        </div>
                    </div>
                </div>
                <div class="card shadow mb-4">
                    <div class="card-header py-3 ">
                        <h6 class="text-primary fw-bold m-0 d-inline">Informações</h6> <a class="d-inline"
                                                                                          data-toggle="modal"
                                                                                          data-target="#CompanyModal">[Editar]</a>
                    </div>
                    <div class="card-body">
                        <p>CNPJ:<span class="cnpj">{{$company->cnpj}}</span></p>
                        <p>Endereço: <span>{{$company->address}}</span></p>
                        <p>Telefone: <span>{{$company->tel0}}</span></p>
                        <p>Email: <span>{{$company->email}}</span></p>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="row mb-3 ">
                    <div class="col">
                        <div class="card textwhite bg-primary text-white shadow">
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col">
                                        <p class="m-0">Criado em</p>
                                        <p class="m-0"><strong>{{$company->created_at}}</strong></p>
                                    </div>
                                    <div class="col-auto"><i class="fas fa-rocket fa-2x"></i></div>
                                </div>
                                <p class="text-white-50 small m-0"><i class="fas fa-arrow-up"></i> 5% since last
                                    month</p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card textwhite bg-success text-white shadow">
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col">
                                        <p class="m-0">Modificado em</p>
                                        <p class="m-0"><strong>{{$company->updated_at}}</strong></p>
                                    </div>
                                    <div class="col-auto"><i class="fas fa-rocket fa-2x"></i></div>
                                </div>
                                <p class="text-white-50 small m-0"><i class="fas fa-arrow-up"></i> 5% since last
                                    month</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="card shadow">
                            <div class="card-header py-3">
                                <p class="text-primary m-0 fw-bold">Informações Básicas</p>
                            </div>
                            <div class="card-body">
                                {!! Form::open(['route'=>['company.setting.update'],'id'=>"infoF"]) !!}

                                    <div class="mb-3"><label class="form-label"
                                                             for="name"><strong>Nome</strong></label><input
                                            type="text" class="form-control" id="name"
                                            placeholder="123 LTDA" name="name" value="{{$company->name??''}}"/></div>

                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3"><label class="form-label"
                                                                     for="tel0"><strong>Telefone</strong></label><input
                                                    type="text" class="form-control tel" id="tel0"
                                                    placeholder="(12)3456-7891" name="tel0"
                                                    value="{{$company->tel0??''}}"/></div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3"><label class="form-label"
                                                                     for="email"><strong>Email</strong></label><input
                                                    type="email" class="form-control email" id="email"
                                                    placeholder="Email"
                                                    name="email" value="{{$company->email??''}}"/></div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3"><label class="form-label"
                                                                     for="cnpj"><strong>Doc</strong></label><input
                                                    type="text" class="form-control cpf_cnpj" id="cnpj"
                                                    placeholder="cnpj" name="cnpj" value="{{$company->cnpj??''}}"/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3"><label class="form-label"
                                                                     for="cep"><strong>CEP</strong></label><input
                                                    type="text" class="form-control cep" id="Cep"
                                                    placeholder="CEP" name="cep" value="{{$company->cep??''}}"/></div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3"><label class="form-label"
                                                                     for="number"><strong>Numero</strong></label><input
                                                    type="number" class="form-control" id="number" placeholder="number"
                                                    name="number" value="{{$company->number??''}}"/></div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3"><label class="form-label"
                                                                     for="complement"><strong>Complemento</strong></label><input
                                                    type="text" class="form-control" id="complement"
                                                    placeholder="complement"
                                                    name="complement" value="{{$company->complement??''}}"/></div>
                                        </div>
                                        <div class="d-none">
                                            <input type="text" name="address" id="Street">
                                            <input type="text" name="district" id="District">
                                            <input type="text" name="city" id="City">
                                            <input type="text" name="state" id=State">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <button class="btn btn-primary btn-sm" type="submit">Salvar</button>
                                    </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <!-- <div class="card shadow mb-5">
             <div class="card-header py-3">
                 <p class="text-primary m-0 fw-bold">Forum Settings</p>
             </div>
             <div class="card-body">
                 <div class="row">
                     <div class="col-md-6">
                         <form>
                             <div class="mb-3"><label class="form-label"
                                                      for="signature"><strong>Signature</strong><br/></label><textarea
                                     class="form-control" id="signature" rows="4" name="signature"></textarea></div>
                             <div class="mb-3">
                                 <div class="form-check form-switch"><input type="checkbox" class="form-check-input"
                                                                            id="formCheck-1"/><label
                                         class="form-check-label" for="formCheck-1"><strong>Notify me about new
                                             replies</strong></label></div>
                             </div>
                             <div class="mb-3">
                                 <button class="btn btn-primary btn-sm" type="submit">Save Settings</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> -->
    </div>
    <!--
    <div class="container pt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Enable Push Messages</div>
                    <div class="card-body">
                        <input type="checkbox" checked data-toggle="toggle" class="js-push-button" id="push-select">
                    </div>
                </div>
            </div>
        </div>
    </div>
            -->

    <x-bootstrap-modal title="Editar Informações" name="companyModal">
        <x-form-input inputClass="cnpj" name="cnpj" title="CNPJ" :value="$company->cnpj??''"></x-form-input>
        <x-form-input name="address" title="Address" :value="$company->address??''"></x-form-input>
        <x-form-input inputClass="tel" name="tel0" title="Telefone" :value="$company->tel0??''"></x-form-input>
        <x-form-input inputClass="email" name="email" title="Email" :value="$company->email??''"></x-form-input>
    </x-bootstrap-modal>
    <x-bootstrap-modal title="Editar Logo" name="logoModal">
        <x-form-file name="logo" title="Logo"></x-form-file>
    </x-bootstrap-modal>
@endsection
@push('css')
    <!-- <link rel="stylesheet" href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css"
          integrity="sha512-hievggED+/IcfxhYRSr4Auo1jbiOczpqpLZwfTVL/6hFACdbI3WQ8S9NCX50gsM9QVE+zLk/8wb9TlgriFbX+Q=="
          crossorigin="anonymous"> -->
@endpush
@push('js')
    <script>
        document.getElementById('Cep').addEventListener('change', function () {
            if (document.getElementById('Cep').value.replace(/[^0-9]/, "").length >= 8) {
                mclients.getCep(document.getElementById('Cep').value);
            }
        })
        $('#CompanyModal-submit').click(function () {
            axios.post('{{route('company.setting.update')}}', {
                cnpj: document.getElementById('Cnpj').value,
                address: document.getElementById('Address').value,
                tel0: document.getElementById('Tel0').value,
                email: document.getElementById('Email').value
            }).then((r) => {
                location.reload(true);
            });
        });
        $('#LogoModal-submit').click(function () {
            let formData = new FormData();
            formData.append("logo", document.getElementById('Logo').files[0]);
            axios.post('{{route('company.setting.update')}}', formData
                , {
                    headers: {'Content-Type': 'multipart/form-data'}
                }).then((r) => {
                location.reload(true);
            });
        });
    </script>
    <!-- <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
            integrity="sha512-eHWYortWe2NyxHIiY/wY82nK4RlPIDDDSD5ZvTHrTkiq9tAe++DBhq5rDcC02xqHxh0ctGGMbHKotqtYcYgXZA=="
            crossorigin="anonymous"></script>
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"
            integrity="sha512-F636MAkMAhtTplahL9F6KmTfxTmYcAcjcCkyu0f0voT3N/6vzAuJ4Num55a0gEJ+hRLHhdz3vDvZpf6kqgEa5w=="
            crossorigin="anonymous"></script>  -->
@endpush
