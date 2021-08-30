@extends('layouts.default')

@section('content')
    <div class="row">
        <div class="col-12">
            <h2>Pedidos Recebidos</h2>
            <hr>
        </div>

        <div class="col-12">

                {!! $dataTable->table() !!}
        </div>
    </div>
@endsection
@push('js')
    {!! $dataTable->scripts() !!}
@endpush
