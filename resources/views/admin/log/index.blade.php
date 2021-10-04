@extends('layouts.default')
@section('page-header') Registro @endsection
@section('content')
    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <table id="dataTable" class="table table-striped table-bordered" cellspacing="0">
            <thead>
            <tr>
                <th>Data</th>
                <th>Funcionário</th>
                <th>Tipo</th>
                <th>Dados Alterados</th>

            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>Data</th>
                <th>Funcionário</th>
                <th>Tipo</th>
                <th>Dados Alterados</th>

            </tr>
            </tfoot>
            <tbody>
            @foreach($activities->all() as $activity)
                <tr>
                    <td>{{$activity->created_at}}</td>
                    <td>{{\App\Models\User::find($activity->causer_id)->name}}</td>
                    <td>{{ __('view.'.explode("\\",$activity->subject_type)[2])}}::{{__('view.'.$activity->description)}} </td>
                    <td>{{($activity->properties->has('old')) ?json_encode( collect($activity->properties['attributes'])->diffAssoc($activity->properties['old'])):''}}
                        @if($activity->properties->has('old'))
                            <ul>
                                <span>Antigo</span>
                                @foreach($activity->properties['old'] as $attribute=>$value)
                                    <li>{{$attribute}}: {{$value}}</li>
                                @endforeach
                            </ul>
                        @endif
                        @if($activity->properties->has('attributes'))
                            <ul>
                                <span>Novo</span>
                                @foreach($activity->properties['attributes'] as $attribute=>$value)
                                    <li>{{$attribute}}: {{$value}}</li>
                                @endforeach
                            </ul>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@endsection
