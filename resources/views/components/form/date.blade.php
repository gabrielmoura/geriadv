<div {{ $attributes->merge(['class'=>"form-group "]) }}>
    <label class="control-label  optional" for="{{ucwords($name)}}">{{$title??strtoupper($name)}}</label>
    <input class="start-date form-control optional date {{$inputClass??''}}"
           data-date-language="pt-BR" type="text"
           name="{{$name}}"
           id="{{ucwords($name)}}"
           value="{{$value??old('birth_date')}}">
</div>
