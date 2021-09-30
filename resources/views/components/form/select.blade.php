<div {{ $attributes->merge(['class'=>"form-group select optional"]) }}>
    <label class="control-label select optional" for="{{ucwords($name)}}">
        {{$title??strtoupper($name)}}</label>
    <select class="form-control select optional" name="{{$name}}" id="{{ucwords($name)}}">
        @foreach($selects as $select)
            <option value="{{$select->value}}">{{$select->name}}</option>
        @endforeach
    </select>
</div>
