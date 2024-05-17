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

            <h1 class="subtitulo2 mt-5">
                Sistema de Calidad
                <small>Has clic sobre el enlace de tu interés.</small>
            </h1>

            <div class="row mt-3">
                <div class="col-md-12">
                    <ul class="breadcrump">
                        <li><a href="{{ route('enlaces.index') }}" class="breadHome"><i class="fad fa-home-alt"></i></a></li>
                        @php $limite = sizeof($parametros['breadcrump']); @endphp
                        @php $ultima = null; @endphp
                        @foreach($parametros['breadcrump'] as $key => $value)
                            @if($key != $limite-1)
                            <li><span class="separador">/</span></li>
                            <li><a href="{{ route('enlaces.getfiles', ['directorio' => $value['url']]) }}" class="breadLink">{{ $value['etiqueta'] }}</a></li>
                            @else
                                @if($key == 0)
                                    @php $ultima = route('enlaces.index'); @endphp
                                @endif

                                @if($key > 0)
                                    @php $ultima = route('enlaces.getfiles', ['directorio' => $parametros['breadcrump'][$key-1]['url']]); @endphp
                                @endif
                            <li><span class="separador">/</span><span class="enlaceHoja">{{ $value['etiqueta'] }}</span></li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <h5 class="subtitulo2">DIRECTORIOS</h5>
                    <ul class="listaEnlaces mt-2">
                        @if($ultima != null)
                        <li><a href="{{ $ultima }}" class="enlaceInteres"><i class="fas fa-level-up-alt me-2"></i> Volver</a></li>
                        @endif

                        @if(!empty($parametros['directorios']))
                            @foreach($parametros['directorios'] as $key => $value)
                                <li><a href="{{ route('enlaces.getfiles', ['directorio' => $value['directorio']]) }}" target="_self" class="enlaceInteres"><i class="fas fa-folder me-2"></i>{{ $value['etiqueta'] }}</a></li>
                            @endforeach
                        @else
                            <li><span>No se encontraron archivos</span></li>
                        @endif
                    </ul>  
                </div>
                <div class="col-md-6">
                    <h5 class="subtitulo2">ARCHIVOS</h5>
                    <ul class="listaEnlaces mt-2">
                        @php $sinarchivos = false; @endphp
                        @if(!empty($parametros['archivos']))
                            @foreach($parametros['archivos'] as $key => $value)
                                @if($value['etiqueta'] != 'Thumbs.db' && strpos($value['etiqueta'], '~$') === false)
                                    @php $sinarchivos = true; @endphp
                                    <li><a href="{{ asset('storage/'.$value['archivo']) }}" target="_blank" class="enlaceInteres"><i class="fas fa-square me-2"></i>{{ $value['etiqueta'] }}</a></li>
                                @endif
                            @endforeach

                            @if(!$sinarchivos)
                            <li><span>No se encontraron archivos</span></li>
                            @endif
                        @else
                            <li><span>No se encontraron archivos</span></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </section>
@endsection