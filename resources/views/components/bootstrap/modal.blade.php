<div {{ $attributes->merge(['aria-hidden'=>true,'aria-labelledby'=>'exampleModalLabel','tabindex'=>"-1",'class'=>"modal fade",'id'=>ucwords($name)]) }} >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{$title??strtoupper($name)}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{ $slot }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="{{ucwords($name)}}-submit">Save changes</button>
            </div>
        </div>
    </div>
</div>
