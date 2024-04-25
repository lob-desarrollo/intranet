@extends('layouts.app')

@push('css')
    @vite(['resources/css/nosotros.css'])
@endpush

@section('content')
    <section class="pt-5 pb-2">
        <div class="container mt-5 mb-5">
            <h1 class="subtitulo2">
                Avisos
                <small>Consulta la comunicación vigente.</small>
            </h1>

            <div class="row mt-5 mb-4 paginado">
                <div class="col-12 sinPadding">
                    @for($i=1; $i<=$parametros['paginas']; $i++)
                    <a href="{{ route('lista.avisos', ['pagina' => $i]) }}" class="pagina {{ $parametros['pagina']==$i?'pagina-activa':'' }}"><span>{{ $i }}</span></a>
                    @endfor
                </div>
            </div>

            @foreach($parametros['avisos'] as $key=>$value)
                <div class="mb-5">
                    <div class="row notificacion">
                        <div class="col-1 sinPadding">
                            <div class="notificacionImagen">
                                <div style="background: {{ $value['color'] }};">
                                    <i class="notificacionTextura {{ $value['imagen'] }}"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-9">
                            <div class="notificacionDescripcion">
                                <div>
                                    <h3 class="notificacionTitulo">
                                        {{ $value['titulo'] }}
                                        <small>{{ $value['fecha'] }}</small>
                                    </h3>
                                    {{ $value['resumen'] }}
                                </div>
                            </div>
                        </div>
                        <div class="col-2 sinPadding">
                            <div class="notificacionBotonera">
                                <div>
                                    <button type="button" data-aviso="{{ $value['id'] }}" data-titulo="{{ cleanstring::cleanForUrl($value['titulo']) }}" class="btnCalendario"><i class="fad fa-hand-point-right"></i> Leer más</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="row paginado">
                <div class="col-12 sinPadding">
                    @for($i=1; $i<=$parametros['paginas']; $i++)
                    <a href="{{ route('lista.avisos', ['pagina' => $i]) }}" class="pagina {{ $parametros['pagina']==$i?'pagina-activa':'' }}"><span>{{ $i }}</span></a>
                    @endfor
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script>
        (function($) {
            principal.avisos();
        })(jQuery);
    </script>
@endpush