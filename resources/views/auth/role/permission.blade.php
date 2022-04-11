<div class="card panel-default mt-5">
    <div class="card-header" role="tab" id="{{ isset($title) ? Str::slug($title) :  'permissionHeading' }}">
        <h4 class="panel-title">
            <a role="button" data-toggle="collapse" data-parent="#acc??dion"
               href="#dd-{{ isset($title) ? Str::slug($title) :  'permissionHeading' }}"
               aria-expanded="{{ $closed ?? 'true' }}"
               aria-controls="dd-{{ isset($title) ? Str::slug($title) :  'permissionHeading' }}">
                {{ $title ?? 'Override Permissions' }} {!! isset($user) ? '<span class="text-danger">(' . $user->getDirectPermissions()->count() . ')</span>' : '' !!}
            </a>
        </h4>
    </div>
    <div id="dd-{{ isset($title) ? Str::slug($title) :  'permissionHeading' }}"
         class="card-body  {{ $closed ?? 'in' }}" role="tabpanel"
         aria-labelledby="dd-{{ isset($title) ? Str::slug($title) :  'permissionHeading' }}">
        <div class="panel-body">
            <div class="row">
                @foreach($permissions as $perm)
                    @php
                        $per_found = null;

                        if (isset($role)) {
                            $per_found = $role->hasPermissionTo($perm->name);
                        }

                        if (isset($user)) {
                            $per_found = $user->hasDirectPermission($perm->name);
                        }
                    @endphp

                    <div class="col-md-3">
                        <div class="form-check">
                            {!! Form::checkbox("permissions[]", $perm->name, $per_found, isset($options) ? $options : ['class'=>'form-check-input','id'=>$perm->name]) !!}
                            <label
                                class="{{ Str::contains($perm->name, 'delete') ? 'text-danger' : '' }} form-check-label"
                                for="{{$perm->name}}">
                                {{ $perm->description }}
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
