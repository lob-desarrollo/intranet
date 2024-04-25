@extends('layouts.app')

@push('css')
    @vite(['resources/css/nosotros.css'])
@endpush

@section('content')
    <section class="pt-5 pb-2">
        <div class="container mt-5 mb-5">
            <div class="row">
                <div class="col-6">
                    <img src="{{ asset('storage/contents/'.$parametros['contenido']['imagen']) }}" class="img-fluid" />
                </div>
                <div class="col-6">
                    <div class="contenidoTabla">
                        <div class="contenidoCelda">
                            <h3 class="subtitulo2">
                                {{ $parametros['contenido']['titulo'] }}
                                <small>{{ $parametros['contenido']['fecha'] }}</small>
                            </h3>

                            <div class="mt-4">
                                {!! $parametros['contenido']['contenido'] !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection