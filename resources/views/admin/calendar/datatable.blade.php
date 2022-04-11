@extends('layouts.default')
@section('page-header') Eventos @endsection
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
                    <div class="col-4">
                        <x-form-date name="date" value="{{$request->date??''}}" title="Data"></x-form-date>
                    </div>
                    <div class="col-4">
                        <x-form-input name="address" value="{{$request->address??''}}"
                                      title="Endereço"></x-form-input>
                    </div>
                    <div class="col-4">
                        <x-form-input name="lawyer" value="{{$request->lawyer??''}}"
                                      title="Advogado"></x-form-input>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary float-right m-r-10">Buscar</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    {!! $html->table(['class'=>'table table-striped table-bordered display nowrap']) !!}
@endsection
@push('js')
    {!! $html->scripts() !!}
@endpush
