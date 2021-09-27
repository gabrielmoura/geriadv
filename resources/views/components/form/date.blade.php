<div {{ $attributes->merge(['class'=>"form-group "]) }}>
    <label class="control-label datepicker optional" for="{{ucwords($name)}}">{{$title??strtoupper($name)}}</label>
    <input class="datepicker optional form-control date {{$inputClass??''}}"
           data-date-language="pt_BR" type="text"
           name="{{$name}}"
           id="{{ucwords($name)}}"
           value="{{old('birth_date')}}">
</div>
