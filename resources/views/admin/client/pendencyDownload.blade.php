<div class="row">
    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="text-primary fw-bold m-0">Enviar Documentos</h6>
            </div>
            <div class="card-body">
                {!! Form::open(['route'=>['admin.clients.pendency'],'files' => true]) !!}
                @php($count=0)
                @foreach(cache('company:'.session()->get('company.id'))->config['docs'] as $name)
                    <input type="hidden" name="slug" value="{{$client->slug}}">
                    @if((is_null($client->pendency))?true:!$client->pendency->{$name})
                        @php($count=+1)
                        <x-form.file name="{{ $name }}"></x-form.file>
                    @endif
                @endforeach
                @if($count>0)
                    <button type="submit">Enviar</button>
                @endif
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
                @foreach(cache('company:'.session()->get('company.id'))->config['docs'] as $name)
                    @if(!is_null($client->pendency))
                        @if($client->pendency->{$name})
                            <p>
                                Acessar <a
                                    href="{{route('admin.clients.pendency.download',['slug'=>$client->slug,'doc'=>$name])}}"
                                    target="_blank">{{strtoupper($name)}}</a> <a
                                    href="#" onclick="deletedoc('{{$name}}','{{$client->slug}}');"><i
                                        class="fad fa-trash-alt red"></i></a>
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
            doc.type = "hidden";
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
