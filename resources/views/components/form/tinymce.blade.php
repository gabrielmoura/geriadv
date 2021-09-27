<div {{ $attributes->merge(['class'=>"form-group text"]) }} >
    <label
        class="control-label text optional" for="{{ucwords($name)}}">{{$title??strtoupper($name)}}</label>
    <textarea
        class="form-control text tiny" rows="3" name="{{$name}}" id="{{ucwords($name)}}">
        {{html_entity_decode( $value??old($value))}}
    </textarea>

</div>
