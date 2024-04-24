@extends('layouts.app')

@push('css')
    @vite(['resources/css/enlaces.css'])
@endpush

@section('content')
    <section class="pt-5 pb-2">
        <div class="container mt-5 mb-5">
            <h1 class="subtitulo2">
                Enlaces
                <small>Has clic sobre el enlace de tu interés.</small>
            </h1>

            <div class="row mt-5">
                @foreach($parametros['enlaces'] as $categoria=>$categorias)
                    <div class="col-3">
                        <h5 class="subtitulo2">{{ $categoria }}</h5>
                        @foreach($categorias as $key=>$value)
                        <ul class="listaEnlaces mt-2">
                            <li><a href="{{ $value['url'] }}" target="_blank" class="enlaceInteres"><i class="fas fa-square me-2"></i>{{ $value['titulo'] }}</a></li>
                        </ul>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection