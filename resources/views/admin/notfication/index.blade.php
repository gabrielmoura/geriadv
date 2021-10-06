@extends('layouts.default')
@section('page-header') Notificações @endsection
@section('content')
    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <table id="dataTable" class="table table-striped table-bordered" cellspacing="0">
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Titulo</th>
                    <th>Mensagem</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Data</th>
                    <th>Titulo</th>
                    <th>Mensagem</th>
                </tr>
            </tfoot>
            <tbody>
            @foreach($notifications as $notification)
                <tr>
                    <td>{{$notification->created_at}}</td>    
                    <td>{{$notification->data['title']}}</td>    
                    <td>{{$notification->data['body']}}</td>    
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@endsection
