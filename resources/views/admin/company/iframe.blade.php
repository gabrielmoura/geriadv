@section('content')
    @foreach($employees as $employee)
        {{$employee->name}}
    @endforeach
    @foreach($clients as $client)
        {{$client->name}}
    @endforeach
@endsection
