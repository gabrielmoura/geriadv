<div {{ $attributes->merge(['class'=>"form-group "]) }}>
    <label class="control-label  optional" for="{{ucwords($name)}}">{{$title??strtoupper($name)}}</label>
    <input class=" optional form-control date-time {{$inputClass??''}}"
           data-date-language="pt_BR" type="text"
           name="{{$name}}"
           id="{{ucwords($name)}}"
           value="{{old('birth_date')}}">
</div>
