@extends('layouts.app')

@push('css')
    @vite(['resources/css/nosotros.css'])
@endpush

@section('content')
    <section class="pt-5 pb-2">
        <div class="container mt-5 mb-5">
            <h3 class="subtitulo2">
                {{ $parametros['contenido']['name'] }} <sup class="alias">aka</sup>
                <small>{{ $parametros['contenido']['nombre'] }}</small>
            </h3>

            <img src="{{ asset('storage/contents/'.$parametros['contenido']['imagen']) }}" class="img-fluid my-5" />

            {!! $parametros['contenido']['contenido'] !!}
        </div>
    </section>
@endsection