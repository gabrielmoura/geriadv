<div {{ $attributes->merge(['class'=>"form-group file"]) }} >
    <label class="control-label file optional" for="{{ucwords($name)}}">
        {{strtoupper($name)}}</label>
    <input class="file optional" type="file" name="{{$name}}" id="{{ucwords($name)}}">
</div>
