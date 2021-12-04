<div class="row">
    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="text-primary fw-bold m-0">Enviar Documentos</h6>
            </div>
            <div class="card-body">
                {!! Form::open(['route'=>['admin.clients.pendency'],'files' => true]) !!}

                @foreach(config('core.docs') as $name)
                    <input type="hidden" name="slug" value="{{$client->slug}}">
                    @if(($client->pendency()->get()->isEmpty())?true:!$client->pendency()->first()->{$name})
                        <x-form-file name="{{ $name }}"></x-form-file>
                    @endif
                @endforeach
                <button type="submit">Enviar</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="text-primary fw-bold m-0">Ver Documentos</h6>
            </div>
            <div class="card-body">
                @foreach(config('core.docs') as $name)
                    @if(!$client->pendency()->get()->isEmpty())
                        @if($client->pendency()->first()->{$name})
                            <p>
                                Acessar <a
                                    href="{{$client->pendency()->first()->getMedia($name)[0]->getUrl()}}"
                                    target="_blank">{{strtoupper($name)}}</a> <a
                                    href="#" onclick="deletedoc('{{$name}}','{{$client->slug}}');"><i
                                        class="ace-icon fa fa-times red"></i></a>
                            </p>
                        @endif
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
{!! Form::open(['route'=>'admin.clients.pendency.delete','id'=>'deleteDoc','method'=>'DELETE']) !!}
{!! Form::close() !!}

@push('js')
    <script>
        let deletedoc = function (docx, slugx) {

            var doc = document.createElement("input");
            doc.type = "text";
            doc.name = "doc";
            doc.value = docx;


            var slug = document.createElement("input");
            slug.type = "hidden";
            slug.name = "slug";
            slug.value = slugx;

            document.getElementById('deleteDoc').appendChild(slug);
            document.getElementById('deleteDoc').appendChild(doc);
            document.getElementById('deleteDoc').submit();
        };
    </script>
@endpush
