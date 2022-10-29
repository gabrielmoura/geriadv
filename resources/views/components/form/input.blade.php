<div {{ $attributes->merge(['class'=>"form-group string"]) }} >
    <label class="control-label  optional" for="{{ucwords($name)}}">
        {{(collect($attributes)->contains($operator='required'))?"*":''}}{{$title??strtoupper($name)}}
    </label>
    <input class="form-control {{$inputClass??''}}"
           type="{{$type}}" name="{{$name}}"
           id="{{ucwords($name)}}"
           placeholder="{{$placeholder}}"
           value="{{html_entity_decode( $value??old($name))}}">
</div>
