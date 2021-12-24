@extends('layouts.default')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ __('global.create') }} {{ __('cruds.event.title_singular') }}
        </div>

        <div class="card-body">
            <form action="{{ route("admin.calendar.store") }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                    <label for="name">{{ __('cruds.event.fields.name') }}*</label>
                    <input type="text" id="name" name="name" class="form-control"
                           value="{{ old('name', isset($event) ? $event->name : '') }}" required>
                    @if($errors->has('name'))
                        <em class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </em>
                    @endif
                    <p class="helper-block">
                        {{ __('cruds.event.fields.name_helper') }}
                    </p>
                </div>
                <x-form-tinymce name="description" title="Descrição"></x-form-tinymce>
                <div class="form-group {{ $errors->has('start_time') ? 'has-error' : '' }}">
                    <label for="start_time">{{ __('cruds.event.fields.start_time') }}*</label>
                    <input type="text" id="start_time" name="start_time" class="form-control date-time "
                           value="{{ old('start_time', isset($event) ? $event->start_time : '') }}" required>
                    @if($errors->has('start_time'))
                        <em class="invalid-feedback">
                            {{ $errors->first('start_time') }}
                        </em>
                    @endif
                    <p class="helper-block">
                        {{ __('cruds.event.fields.start_time_helper') }}
                    </p>
                </div>
                <div class="form-group {{ $errors->has('end_time') ? 'has-error' : '' }}">
                    <label for="end_time">{{ __('cruds.event.fields.end_time') }}*</label>
                    <input type="text" id="end_time" name="end_time" class="form-control date-time  "
                           value="{{ old('end_time', isset($event) ? $event->end_time : '') }}" required>
                    @if($errors->has('end_time'))
                        <em class="invalid-feedback">
                            {{ $errors->first('end_time') }}
                        </em>
                    @endif
                    <p class="helper-block">
                        {{ __('cruds.event.fields.end_time_helper') }}
                    </p>
                </div>
                <div class="form-group {{ $errors->has('recurrence') ? 'has-error' : '' }}">
                    <label>{{ __('cruds.event.fields.recurrence') }}*</label>
                    @foreach(\App\Models\Calendar::RECURRENCE_RADIO as $key => $label)
                        <div>
                            <input id="recurrence_{{ $key }}" name="recurrence" type="radio" value="{{ $key }}"
                                   {{ old('recurrence', 'none') === (string)$key ? 'checked' : '' }} required>
                            <label for="recurrence_{{ $key }}">{{ $label }}</label>
                        </div>
                    @endforeach
                    @if($errors->has('recurrence'))
                        <em class="invalid-feedback">
                            {{ $errors->first('recurrence') }}
                        </em>
                    @endif
                </div>


                <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
                    <label for="name">{{ __('cruds.event.fields.address') }}</label>
                    <input type="text" id="address" name="address" class="form-control"
                           value="{{ old('name', isset($event) ? $event->address : '') }}" >
                    @if($errors->has('address'))
                        <em class="invalid-feedback">
                            {{ $errors->first('address') }}
                        </em>
                    @endif
                    <p class="helper-block">
                        {{ __('cruds.event.fields.address_helper') }}
                    </p>
                </div>

                <x-form-select name="lawyer_id" :title="__('cruds.event.fields.lawyer')" :selects="$lawyer??[]"></x-form-select>

                <div>
                    <input class="btn btn-success" type="submit" value="{{ __('global.save') }}">
                </div>
            </form>


        </div>
    </div>
@endsection
