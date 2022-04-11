@extends('layouts.default')
@section('page-header') Empresa @endsection
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
                            <!--<button class="btn btn-primary btn-sm" type="button">Change Photo</button>-->
                        </div>
                    </div>
                </div>
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="text-primary fw-bold m-0">Informações</h6>
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
                                        {!! Form::open(['route'=>['admin.company.destroy','company'=>$company->id],'method'=>'DELETE','id'=>'delete']) !!}
                                        <a class="btn btn-danger" onclick="document.getElementById('delete').submit();">Deletar
                                            Empresa</a>
                                        {!! Form::close() !!}
                                    </div>
                                    <div class="p-1">
                                        @if($company->banned)
                                            <a class="btn btn-warning" onclick="unban({{$company->id}});">Desbanir
                                                Empresa</a>
                                        @else
                                            <a class="btn btn-warning" onclick="ban({{$company->id}});">Banir
                                                Empresa</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card shadow mb-3">
                            <div class="card-header py-3">
                                <p class="text-primary m-0 fw-bold">Estatisticas</p>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <div class="card textwhite bg-primary text-white shadow">
                                            <div class="card-body">
                                                <div class="row mb-2">
                                                    <div class="col">
                                                        <p class="m-0">Total de Clientes</p>
                                                        <p class="m-0"><strong>{{$company->clients()->count()}}</strong>
                                                        </p>
                                                    </div>
                                                    <div class="col-auto"><i class="fas fa-rocket fa-2x"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="card textwhite bg-primary text-white shadow">
                                            <div class="card-body">
                                                <div class="row mb-2">
                                                    <div class="col">
                                                        <p class="m-0">Total de Funcionários</p>
                                                        <p class="m-0">
                                                            <strong>{{$company->employees()->count()}}</strong></p>
                                                    </div>
                                                    <div class="col-auto"><i class="fas fa-rocket fa-2x"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <div class="row mt-2">
                                    <div class="col">
                                        <div class="card textwhite bg-primary text-white shadow">
                                            <div class="card-body">
                                                <div class="row mb-2">
                                                    <div class="col">
                                                        <p class="m-0">Total de Advogados</p>
                                                        <p class="m-0"><strong>{{$company->lawyers()->count()}}</strong>
                                                        </p>
                                                    </div>
                                                    <div class="col-auto"><i class="fas fa-rocket fa-2x"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="card textwhite bg-primary text-white shadow">
                                            <div class="card-body">
                                                <div class="row mb-2">
                                                    <div class="col">
                                                        <p class="m-0">Total de Agendamentos</p>
                                                        <p class="m-0">
                                                            <strong>{{$company->calendars()->count()}}</strong></p>
                                                    </div>
                                                    <div class="col-auto"><i class="fas fa-rocket fa-2x"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="card shadow">
                             <div class="card-header py-3">
                                 <p class="text-primary m-0 fw-bold">Contact Settings</p>
                             </div>
                             <div class="card-body">
                                 <form>
                                     <div class="mb-3"><label class="form-label"
                                                              for="address"><strong>Address</strong></label><input
                                             type="text" class="form-control" id="address"
                                             placeholder="Sunset Blvd, 38" name="address"/></div>
                                     <div class="row">
                                         <div class="col">
                                             <div class="mb-3"><label class="form-label"
                                                                      for="city"><strong>City</strong></label><input
                                                     type="text" class="form-control" id="city"
                                                     placeholder="Los Angeles" name="city"/></div>
                                         </div>
                                         <div class="col">
                                             <div class="mb-3"><label class="form-label" for="country"><strong>Country</strong></label><input
                                                     type="text" class="form-control" id="country" placeholder="USA"
                                                     name="country"/></div>
                                         </div>
                                     </div>
                                     <div class="mb-3">
                                        <button class="btn btn-primary btn-sm" type="submit">Save Settings</button>--
                                     </div>
                                 </form>
                             </div>
                         </div> -->
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
@endsection
@push('js')
    <script type="text/javascript">
        let ban = function (companyID) {
            axios.post('{{route('ajax.ban')}}', {company: companyID})
                .then(function (response) {
                    document.location.reload(true);
                });
        }, unban = function (companyID) {
            axios.post('{{route('ajax.unban')}}', {company: companyID})
                .then(function (response) {
                    document.location.reload(true);
                });
        };
    </script>
@endpush

