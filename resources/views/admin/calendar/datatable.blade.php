@extends('layouts.default')
@section('title', 'Agendamento')
@section('page-header')
    Eventos
@endsection
@section('content')
    @hasrole('manager|employees')
    <a class="btn btn-success" href="{{ route("admin.calendar.create") }}">
        {{ __('global.add') }} {{ __('cruds.event.title_singular') }}
    </a>
    @endhasrole

    <div class="col-xl-12 ui-sortable">

        <div class=" " data-sortable-id="form-stuff-4">


            <div class="card-body">
                {!! Form::open(['route'=>['admin.calendar.index'],'method'=>'GET']) !!}
                <div class="form-group row">
                    <div class="col-3">
                        <x-form.date name="date" value="{{$request->date??''}}" title="Data"></x-form.date>
                    </div>
                    <div class="col-3">

                        <x-form.select name="month" title="Mês" :selects="[
    ['name'=>'Nenhum','value'=>null],
 ['name'=>'Janeiro','value'=>1],
  ['name'=>  'Fevereiro','value'=>2],
  ['name'=>  'Março','value'=>3],
  ['name'=>  'Abril','value'=>4],
  ['name'=>  'Maio','value'=>5],
 ['name'=>   'Junho','value'=>6],
  ['name'=>  'Julho','value'=>7],
  ['name'=>  'Agosto','value'=>8],
  ['name'=>  'Setembro','value'=>9],
  ['name'=>  'Outubro','value'=>10],
 ['name'=>   'Novembro','value'=>11],
  ['name'=>  'Dezembro','value'=>12],
]" selected="{{$request->month}}"></x-form.select>
                    </div>
                    <div class="col-3">
                        <x-form.input name="address" value="{{$request->address??''}}"
                                      title="Endereço"></x-form.input>
                    </div>
                    <div class="col-3">
                        <x-form.input name="lawyer" value="{{$request->lawyer??''}}"
                                      title="Advogado"></x-form.input>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary float-right m-r-10">Buscar</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    {!! $dataTable->table(['class'=>'table table-striped table-bordered display nowrap']) !!}
@endsection
@push('js')
    <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
    {!! $dataTable->scripts() !!}
@endpush
