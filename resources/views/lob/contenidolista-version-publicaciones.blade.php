@extends('layouts.app')

@push('css')
    @vite(['resources/css/nosotros.css'])
@endpush

@section('content')
    <section class="pt-5 pb-2">
        <div class="container mt-5 mb-5">
            <h1 class="subtitulo2">
                Nuestra Gente
                <small>Consulta la comunicación vigente.</small>
            </h1>

            <div class="row mt-5 mb-4 paginado">
                <div class="col-12 sinPadding">
                    @for($i=1; $i<=$parametros['paginas']; $i++)
                    <a href="{{ route('lista.contenidos', ['pagina' => $i]) }}" class="pagina {{ $parametros['pagina']==$i?'pagina-activa':'' }}"><span>{{ $i }}</span></a>
                    @endfor
                </div>
            </div>

            @foreach($parametros['contenidos'] as $key=>$value)
                @if($key%2 == 0)
                    <section class="py-5">
                        <div class="row">
                            <div class="col-md-6">
                                <img src="{{ asset('storage/contents/'.$value['imagen']) }}" class="img-fluid" />
                            </div>
                            <div class="col-md-6">
                                <div class="contenidoTabla">
                                    <div class="contenidoCeldaVertical">
                                        <h3 class="notificacionTitulo">
                                            {{ $value['titulo'] }}
                                            <small>{{ $value['fecha'] }}</small>
                                        </h3>

                                        {{ $value['resumen'] }}

                                        <div class="notificacionBotonera">
                                            <div>
                                                <button type="button" data-contenido="{{ $value['id'] }}" data-titulo="{{ cleanstring::cleanForUrl($value['titulo']) }}" class="btnCalendario"><i class="fad fa-hand-point-right"></i> Leer más</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                @else
                    <section class="py-5">
                        <div class="row">
                            <div class="col-md-6 order-lg-2">
                                <img src="{{ asset('storage/contents/'.$value['imagen']) }}" class="img-fluid" />
                            </div>
                            <div class="col-md-6 order-lg-1">
                                <div class="contenidoTabla">
                                    <div class="contenidoCeldaVertical">
                                        <h3 class="notificacionTitulo">
                                            {{ $value['titulo'] }}
                                            <small>{{ $value['fecha'] }}</small>
                                        </h3>

                                        {{ $value['resumen'] }}

                                        <div class="notificacionBotonera">
                                            <div>
                                                <button type="button" data-contenido="{{ $value['id'] }}" data-titulo="{{ cleanstring::cleanForUrl($value['titulo']) }}" class="btnCalendario"><i class="fad fa-hand-point-right"></i> Leer más</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                @endif
            @endforeach

            <div class="row paginado">
                <div class="col-12 sinPadding">
                    @for($i=1; $i<=$parametros['paginas']; $i++)
                    <a href="{{ route('lista.contenidos', ['pagina' => $i]) }}" class="pagina {{ $parametros['pagina']==$i?'pagina-activa':'' }}"><span>{{ $i }}</span></a>
                    @endfor
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script>
        (function($) {
            principal.contenidos();
        })(jQuery);
    </script>
@endpush