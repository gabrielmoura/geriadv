@extends('layouts.default')
@section('page-header') Pagamentos @endsection

@section('content')
@foreach ($billets as $billet)
    Satatus {{$billet['status']}}
    Valor {{$billet['value_cents']}}
   Data de Vencimento {{$billet['due_date']}}
    @foreach ($billet['bank_slip'] as $bank_slip)
        {{print_r($bank_slip)}}
    @endforeach
@endforeach
@endsection