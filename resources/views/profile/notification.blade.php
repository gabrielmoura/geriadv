@extends('layouts.default')
@section('title', 'Notificações')
@section('content')
    <div class="container-fluid">
        <h3 class="text-dark mb-4">Avisos</h3>
        <div class="col-lg-12">
            <div class="row">
                <div class="col">
                    <div class="card shadow mb-3">
                        @can('send_notification')
                            <div class="card-header py-3">
                                <a class="btn btn-primary" href="{{route('admin.notifications.create')}}">Enviar MP</a>
                            </div>
                        @endcan
                        <div class="card-body">
                            <ul class="ovY-a pos-r scrollable lis-n p-0 m-0 fsz-sm">
                                @foreach($notifications as $notice)
                                    <li>
                                        <a href="#" class='peers fxw-nw td-n p-20 bdB c-grey-800 cH-blue bgcH-grey-100'
                                           onclick="readNotification('{{$notice->id}}');">
                                            <input type="hidden" name="notification" id="notification_id">
                                            <div class="peer mR-15">
                                                @if(is_null($notice->read_at))
                                                    <i class="fal fa-envelope fa-2x"></i>
                                                @else
                                                    <i class="fal fa-envelope-open fa-2x"></i>
                                                @endif
                                            </div>
                                            <div class="peer mR-15">
                                                <span>Por: {{$notice->data['from']['name']}}</span>
                                            </div>
                                            <div class="peer peer-greed">

                                                <span>

                                            <span class="fw-500">{{$notice->data['title']}}</span>
                                            <span class="c-grey-600">{!! $notice->data['body'] !!}
                                            </span>
                                        </span>
                                                <p class="m-0">
                                                    <small class="fsz-xs">{{$notice['created_at']}}</small>
                                                </p>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script type="text/javascript">
        function readNotification(id) {
            axios.post('{{route('admin.notifications.markAsRead')}}', {id: id})
                .then(function (response) {
                    location.reload();
                });
        }
    </script>
@endpush
