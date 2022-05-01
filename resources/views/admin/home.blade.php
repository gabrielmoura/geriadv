@extends('layouts.default')

@section('content')
    <section class="clean-block clean-faq dark">
        <div class="container">
            <div class="block-heading">
                <h2 class="text-info">Bem Vindo ao {{session('company.name')??config('app.name')}}</h2>
            </div>
        </div>
    </section>
@endsection
