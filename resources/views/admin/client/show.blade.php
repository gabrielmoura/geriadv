@extends('layouts.default')
@section('page-header') Clientes @endsection
@section('content')

    <div class="tabbable">
        <ul class="nav nav-tabs padding-18">
            <li class="active">
                <a data-toggle="tab" href="#home">
                    <i class="green ace-icon fa fa-user bigger-120"></i>
                    Geral
                </a>
            </li>

            <li>
                <a data-toggle="tab" href="#status">
                    <i class="orange ace-icon fa fa-rss bigger-120"></i>
                    Status
                </a>
            </li>

            <li>
                <a data-toggle="tab" href="#doc">
                    <i class="blue ace-icon fa fa-users bigger-120"></i>
                    Documentos
                </a>
            </li>

            <li>
                <a data-toggle="tab" href="#pictures">
                    <i class="pink ace-icon fa fa-picture-o bigger-120"></i>
                    Pictures
                </a>
            </li>
        </ul>

        <div class="tab-content no-border padding-24">
            <div id="home" class="tab-pane in active">
                <div class="row">
                    <div class="col-xs-12 col-sm-3 center">
              <span class="profile-picture">
                <img class="editable img-responsive" alt=" Avatar" id="avatar2"
                     src="{{$client->avatar()}}">
              </span>

                        <div class="space space-4"></div>

                        <!--   <a href="#" class="btn btn-sm btn-block btn-success">
                               <i class="ace-icon fa fa-plus-circle bigger-120"></i>
                               <span class="bigger-110">Add as a friend</span>
                           </a> -->

                        <a href="#" class="btn btn-sm btn-block btn-primary" data-toggle="modal"
                           data-target="#MailModal">
                            <i class="ace-icon fa fa-envelope-o bigger-110"></i>
                            <span class="bigger-110">Enviar Email</span>
                        </a>
                    </div><!-- /.col -->

                    <div class="col-xs-12 col-sm-9">
                        <h4 class="blue d-inline p-2">
                            <span class="middle">{{$client->fullname}}</span>
                        </h4>
                        <span class="d-inline p-2">{{Carbon\Carbon::parse($client->birth_date)->diffForHumans()}}</span>

                        <div class="profile-user-info">


                            <div class="profile-info-row">
                                <div class="profile-info-name">Endereço</div>

                                <div class="profile-info-value">
                                    <i class="fa fa-map-marker light-orange bigger-110"></i>
                                    <span>{{$client->address}} {{$client->number}} {{$client->complement}}</span>
                                    <span>{{$client->district}} {{$client->city}} {{$client->state}}</span>
                                    <span>{{$client->cep}}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> Sexo</div>

                                <div class="profile-info-value">
                                    <span>{{__('view.sex.'.$client->sex)}}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> Data de Nascimento</div>

                                <div class="profile-info-value">
                                    <span>{{formatDate($client->birth_date)}}</span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"> CPF</div>

                                <div class="profile-info-value">
                                    <span class="cpf">{{$client->cpf}}</span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"> RG</div>

                                <div class="profile-info-value">
                                    <span>{{$client->rg}}</span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Situação</div>

                                <div class="profile-info-value">
                                    @forelse($client->status()->get() as $status)
                                        <p><b>{{__('view.'.$status->status) }}</b> {{formatHours($status->created_at)}}
                                        </p>
                                    @empty
                                        <p>Sem Entrada</p>
                                    @endforelse
                                    <button type="button" class="btn btn-primary"
                                            data-toggle="modal"
                                            data-target="#StatusModal">Alterar Situação
                                    </button>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> Beneficio Requerido</div>

                                <div class="profile-info-value">
                                    <button type="button"
                                            class="btn btn-">{{($client->benefits()->get()->isEmpty())?'':$client->benefits()->first()->name}}</button>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> Indicação</div>

                                <div class="profile-info-value">
                                    <button type="button"
                                            class="btn btn-">{{($client->recommendation()->get()->isEmpty())?'':$client->recommendation()->first()->name}}</button>
                                </div>
                            </div>

                        </div>

                        <div class="hr hr-8 dotted"></div>

                        <div class="profile-user-info">
                            {{-- <div class="profile-info-row">
                                 <div class="profile-info-name"> Website</div>

                                 <div class="profile-info-value">
                                     <a href="#" target="_blank">www.alexdoe.com</a>
                                 </div>
                             </div>

                             <div class="profile-info-row">
                                 <div class="profile-info-name">
                                     <i class="middle ace-icon fa fa-facebook-square bigger-150 blue"></i>
                                 </div>

                                 <div class="profile-info-value">
                                     <a href="#">Find me on Facebook</a>
                                 </div>
                             </div>

                             <div class="profile-info-row">
                                 <div class="profile-info-name">
                                     <i class="middle ace-icon fa fa-twitter-square bigger-150 light-blue"></i>
                                 </div>

                                 <div class="profile-info-value">
                                     <a href="#">Follow me on Twitter</a>
                                 </div>
                             </div> --}}
                        </div>
                    </div><!-- /.col -->
                </div><!-- /.row -->

                <div class="space-20"></div>

                <div class="row">
                    <div class="col-xs-12 col-sm-6">
                        <div class="widget-box transparent">
                            <div class="widget-header widget-header-small">
                                <h4 class="widget-title smaller">
                                    <i class="ace-icon fa fa-check-square-o bigger-110"></i>
                                    Observação
                                    <button type="button" class="btn btn-primary p-2" data-toggle="modal"
                                            data-target="#NoteModal">
                                        Adicionar Observação
                                    </button>
                                </h4>

                            </div>

                            <div class="widget-body">
                                <div class="widget-main">
                                    <div class="padding-2">
                                        @foreach($client->note()->get() as $note)
                                            {!! $note->body !!}
                                            <hr>
                                        @endforeach
                                    </div>
                                    {{-- $client->note()->get()->last()->body --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- /#home -->

            <div id="status" class="tab-pane">
                <div class="profile-feed row">
                    <div class="col-sm-6">
                        @foreach($client->status()->get() as $status)
                            <div class="profile-activity clearfix">
                                <div>
                                    <img class="pull-left" alt="Alex Doe's avatar"
                                         src="https://bootdey.com/img/Content/avatar/avatar1.png">
                                    <a class="user" href="#"> {{$status}} </a>
                                    changed his profile photo.
                                    <a href="#">Take a look</a>

                                    <div class="time">
                                        <i class="ace-icon fa fa-clock-o bigger-110"></i>
                                        an hour ago
                                    </div>
                                </div>

                                <div class="tools action-buttons">
                                    <a href="#" class="blue">
                                        <i class="ace-icon fa fa-pencil bigger-125"></i>
                                    </a>

                                    <a href="#" class="red">
                                        <i class="ace-icon fa fa-times bigger-125"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach

                    </div><!-- /.col -->

                    <div class="col-sm-6">
                        @foreach($client->status()->get() as $status)
                            <div class="profile-activity clearfix">
                                <div>
                                    <i class="pull-left thumbicon fa fa-pencil-square-o btn-pink no-hover"></i>
                                    <a class="user" href="#"> Alex Doe </a>
                                    published a new blog post.
                                    <a href="#">Read now</a>

                                    <div class="time">
                                        <i class="ace-icon fa fa-clock-o bigger-110"></i>
                                        11 hours ago
                                    </div>
                                </div>

                                <div class="tools action-buttons">
                                    <a href="#" class="blue">
                                        <i class="ace-icon fa fa-pencil bigger-125"></i>
                                    </a>

                                    <a href="#" class="red">
                                        <i class="ace-icon fa fa-times bigger-125"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach

                    </div><!-- /.col -->
                </div><!-- /.row -->

                <div class="space-12"></div>

                <div class="center">
                    <button type="button" class="btn btn-sm btn-primary btn-white btn-round">
                        <i class="ace-icon fa fa-rss bigger-150 middle orange2"></i>
                        <span class="bigger-110">View more activities</span>

                        <i class="icon-on-right ace-icon fa fa-arrow-right"></i>
                    </button>
                </div>
            </div><!-- /#status -->

            <div id="doc" class="tab-pane">
                <div class="profile-users clearfix">
                    {!! Form::open(['route'=>'admin.clients.pendency','files'=>true]) !!}
                    <input type="hidden" name="slug" value="{{$client->slug}}">


                    @if($client->pendency()->first()==null || ($client->pendency()->first()!=null && !$client->pendency()->first()->cras))
                        <x-form-file name="cras" title="cras">
                            <button>Apagar</button>
                        </x-form-file>
                    @endif

                    @if($client->pendency()->first()==null || ($client->pendency()->first()!=null && !$client->pendency()->first()->cpf))
                        <x-form-file name="cpf" title="cpf">
                            <button>Apagar</button>
                        </x-form-file>
                    @endif

                    @if($client->pendency()->first()==null || ($client->pendency()->first()!=null && !$client->pendency()->first()->rg))
                        <x-form-file name="rg" title="rg">
                            <button>Apagar</button>
                        </x-form-file>
                    @endif

                    @if($client->pendency()->first()==null || ($client->pendency()->first()!=null && !$client->pendency()->first()->birth_certificate))
                        <x-form-file name="birth_certificate" title="Certidão de Nascimento">
                            <button>Apagar</button>
                        </x-form-file>
                    @endif

                    @if($client->pendency()->first()==null || ($client->pendency()->first()!=null && !$client->pendency()->first()->proof_of_address))
                        <x-form-file name="proof_of_address" title="Comprovante de Residencia">
                            <button>Apagar</button>
                        </x-form-file>
                    @endif

                    <button type="submit">Enviar</button>
                    {!! Form::close() !!}
                </div>

                <div class="hr hr10 hr-double"></div>

                <ul class="pager pull-right">
                    <li class="previous disabled">
                        <a href="#">← Prev</a>
                    </li>

                    <li class="next">
                        <a href="#">Next →</a>
                    </li>
                </ul>
            </div><!-- /#doc -->

            <div id="pictures" class="tab-pane">
                <ul class="ace-thumbnails">
                    <li>
                        <a href="#" data-rel="colorbox">
                            <img alt="150x150" src="https://via.placeholder.com/200x200/">
                            <div class="text">
                                <div class="inner">Sample Caption on Hover</div>
                            </div>
                        </a>

                        <div class="tools tools-bottom">
                            <a href="#">
                                <i class="ace-icon fa fa-link"></i>
                            </a>

                            <a href="#">
                                <i class="ace-icon fa fa-paperclip"></i>
                            </a>

                            <a href="#">
                                <i class="ace-icon fa fa-pencil"></i>
                            </a>

                            <a href="#">
                                <i class="ace-icon fa fa-times red"></i>
                            </a>
                        </div>
                    </li>

                    <li>
                        <a href="#" data-rel="colorbox">
                            <img alt="150x150" src="https://via.placeholder.com/200x200/">
                            <div class="text">
                                <div class="inner">Sample Caption on Hover</div>
                            </div>
                        </a>

                        <div class="tools tools-bottom">
                            <a href="#">
                                <i class="ace-icon fa fa-link"></i>
                            </a>

                            <a href="#">
                                <i class="ace-icon fa fa-paperclip"></i>
                            </a>

                            <a href="#">
                                <i class="ace-icon fa fa-pencil"></i>
                            </a>

                            <a href="#">
                                <i class="ace-icon fa fa-times red"></i>
                            </a>
                        </div>
                    </li>

                    <li>
                        <a href="#" data-rel="colorbox">
                            <img alt="150x150" src="https://via.placeholder.com/200x200/">
                            <div class="text">
                                <div class="inner">Sample Caption on Hover</div>
                            </div>
                        </a>

                        <div class="tools tools-bottom">
                            <a href="#">
                                <i class="ace-icon fa fa-link"></i>
                            </a>

                            <a href="#">
                                <i class="ace-icon fa fa-paperclip"></i>
                            </a>

                            <a href="#">
                                <i class="ace-icon fa fa-pencil"></i>
                            </a>

                            <a href="#">
                                <i class="ace-icon fa fa-times red"></i>
                            </a>
                        </div>
                    </li>

                    <li>
                        <a href="#" data-rel="colorbox">
                            <img alt="150x150" src="https://via.placeholder.com/200x200/">
                            <div class="text">
                                <div class="inner">Sample Caption on Hover</div>
                            </div>
                        </a>

                        <div class="tools tools-bottom">
                            <a href="#">
                                <i class="ace-icon fa fa-link"></i>
                            </a>

                            <a href="#">
                                <i class="ace-icon fa fa-paperclip"></i>
                            </a>

                            <a href="#">
                                <i class="ace-icon fa fa-pencil"></i>
                            </a>

                            <a href="#">
                                <i class="ace-icon fa fa-times red"></i>
                            </a>
                        </div>
                    </li>

                    <li>
                        <a href="#" data-rel="colorbox">
                            <img alt="150x150" src="https://via.placeholder.com/200x200/">
                            <div class="text">
                                <div class="inner">Sample Caption on Hover</div>
                            </div>
                        </a>

                        <div class="tools tools-bottom">
                            <a href="#">
                                <i class="ace-icon fa fa-link"></i>
                            </a>

                            <a href="#">
                                <i class="ace-icon fa fa-paperclip"></i>
                            </a>

                            <a href="#">
                                <i class="ace-icon fa fa-pencil"></i>
                            </a>

                            <a href="#">
                                <i class="ace-icon fa fa-times red"></i>
                            </a>
                        </div>
                    </li>

                    <li>
                        <a href="#" data-rel="colorbox">
                            <img alt="150x150" src="https://via.placeholder.com/200x200/">
                            <div class="text">
                                <div class="inner">Sample Caption on Hover</div>
                            </div>
                        </a>

                        <div class="tools tools-bottom">
                            <a href="#">
                                <i class="ace-icon fa fa-link"></i>
                            </a>

                            <a href="#">
                                <i class="ace-icon fa fa-paperclip"></i>
                            </a>

                            <a href="#">
                                <i class="ace-icon fa fa-pencil"></i>
                            </a>

                            <a href="#">
                                <i class="ace-icon fa fa-times red"></i>
                            </a>
                        </div>
                    </li>

                    <li>
                        <a href="#" data-rel="colorbox">
                            <img alt="150x150" src="https://via.placeholder.com/200x200/">
                            <div class="text">
                                <div class="inner">Sample Caption on Hover</div>
                            </div>
                        </a>

                        <div class="tools tools-bottom">
                            <a href="#">
                                <i class="ace-icon fa fa-link"></i>
                            </a>

                            <a href="#">
                                <i class="ace-icon fa fa-paperclip"></i>
                            </a>

                            <a href="#">
                                <i class="ace-icon fa fa-pencil"></i>
                            </a>

                            <a href="#">
                                <i class="ace-icon fa fa-times red"></i>
                            </a>
                        </div>
                    </li>

                    <li>
                        <a href="#" data-rel="colorbox">
                            <img alt="150x150" src="https://via.placeholder.com/200x200/">
                            <div class="text">
                                <div class="inner">Sample Caption on Hover</div>
                            </div>
                        </a>

                        <div class="tools tools-bottom">
                            <a href="#">
                                <i class="ace-icon fa fa-link"></i>
                            </a>

                            <a href="#">
                                <i class="ace-icon fa fa-paperclip"></i>
                            </a>

                            <a href="#">
                                <i class="ace-icon fa fa-pencil"></i>
                            </a>

                            <a href="#">
                                <i class="ace-icon fa fa-times red"></i>
                            </a>
                        </div>
                    </li>
                </ul>
            </div><!-- /#pictures -->
        </div>
    </div>

    <x-bootstrap-modal title="Observação" name="noteModal">
        <x-form-tinymce name="note" title="Observação"></x-form-tinymce>
    </x-bootstrap-modal>
    <x-bootstrap-modal title="E-Mail" name="mailModal">
        <x-form-tinymce name="mail" title="E-Mail"></x-form-tinymce>
    </x-bootstrap-modal>
    <x-bootstrap-modal title="Status" name="statusModal">
        @php($selects=[['value'=>'deferred','name'=>'Deferido'],['value'=>'rejected','name'=>'Indeferido'],['value'=>'analysis','name'=>'Analise'],['value'=>'called_off','name'=>'Cancelado'],['value'=>'deceased','name'=>'Falecido'],['value'=>'cancellation','name'=>'Solicitou Cancelamento']])
        <x-form-select :selects="$selects" name="status" title="Status"></x-form-select>
    </x-bootstrap-modal>
@endsection
@push('js')
    <script>

        $('#NoteModal-submit').click(function () {
            mclients.setNote(tinymce.activeEditor.getContent(),{{$client->id}});
            var times = 0;
            setInterval(function () {
                if (mclients.status !== false) {
                    location.reload(true);
                } else {
                    $('#NoteModal').modal('hide')

                    times++
                    if (times >= 2 < 4) {
                        //toastr.error('Erro ao criar Observação', 'Erro');
                        setTimeout(function () {
                            location.reload(true);
                        }, 500);
                    }
                }
            }, 1000);
        });
        $('#StatusModal-submit').click(function () {
            mclients.setStatus({{$client->id}}, document.getElementById('Status').value,{{auth()->id()}});
            var times = 0;
            setInterval(function () {
                if (mclients.status !== false) {
                    location.reload(true);
                } else {
                    $('#StatusModal').modal('hide')

                    times++
                    if (times >= 2 < 4) {
                        //toastr.error('Erro ao atualizar Status', 'Erro');
                        setTimeout(function () {
                            location.reload(true);
                        }, 500);
                    }
                }
            }, 1000);
        });
        $('#MailModal-submit').click(function () {
            mclients.sendMail(tinymce.activeEditor.getContent(),{{$client->id}});
            var times = 0;
            setInterval(function () {
                if (mclients.status !== false) {
                    toastr.success('Email encaminhado');
                } else {
                    $('#MailModal').modal('hide')

                    times++
                    if (times >= 2 < 4) {
                        //toastr.error('Erro ao criar Observação', 'Erro');
                        setTimeout(function () {
                            toastr.success('Email encaminhado');
                        }, 500);
                    }
                }
            }, 1000);
        });
    </script>
@endpush
@push('css')
    <link charset='utf-8' href='{{mix('css/client.css')}}' media='screen' rel='stylesheet' type='text/css'>
@endpush
