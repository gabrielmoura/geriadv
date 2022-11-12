@extends('layouts.default')
@section('title', 'Funcionários')
@section('page-header')
    Funcionário
@endsection
@section('content')

    <div class="container-fluid">
        <h3 class="text-dark mb-4">{{$employee->name??null}} {{$employee->last_name}}</h3>
        <div class="row mb-3">

            <div class="col-lg-4">
                <div class="card mb-3">
                    <div class="card-body text-center shadow">
                        <img class="rounded-circle mb-3 mt-4"
                             src="https://ui-avatars.com/api/?rounded=true&name={{$employee->name.' '.$employee->last_name}}"
                             width="160" height="160"/>
                        <div class="mb-3">
                            <!--<button class="btn btn-primary btn-sm" type="button">Change Photo</button>-->
                        </div>
                    </div>
                </div>
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="text-primary fw-bold m-0">Informações</h6>
                    </div>
                    <div class="card-body">
                        <p>CPF: {{$employee->cpf}}</p>
                        <p>Sexo: {{$employee->sex}}</p>
                        <p>Endereço: {{$employee->address}}</p>
                        <p>Telefone: {{$employee->tel0}}</p>
                        <p>Data de Nascimento: {{$employee->birth_date}}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="row mb-3 d-none">
                    <div class="col">
                        <div class="card textwhite bg-primary text-white shadow">
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col">
                                        <p class="m-0">Peformance</p>
                                        <p class="m-0"><strong>65.2%</strong></p>
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
                                        <p class="m-0">Peformance</p>
                                        <p class="m-0"><strong>65.2%</strong></p>
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

                        <div class="card shadow mb-3">
                            <div class="card-header py-3">
                                <p class="text-primary m-0 fw-bold">Ferramentas Administrativas</p>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="p-1">

                                    </div>
                                    <div class="p-1">
                                        @if($employee->banned)
                                            <a class="btn btn-warning" onclick="unban('{{$employee->pid}}');">Desativar
                                                Funcionário</a>
                                        @else
                                            <a class="btn btn-success" onclick="ban('{{$employee->pid}}');">Ativar
                                                Funcionário</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
@push('js')
    <script type="text/javascript">
        let ban = function (companyID) {
            axios.post('{{route('ajax.employee.ban')}}', {pid: companyID})
                .then(function (response) {
                    document.location.reload(true);
                });
        }, unban = function (companyID) {
            axios.post('{{route('ajax.employee.unban')}}', {pid: companyID})
                .then(function (response) {
                    document.location.reload(true);
                });
        };
    </script>
@endpush
