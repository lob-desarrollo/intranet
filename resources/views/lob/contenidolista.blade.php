@extends('layouts.app')

@push('css')
    @vite(['resources/css/nosotros.css'])
@endpush

@section('content')
    <section class="pt-5 pb-2">
        <div class="container mt-5 mb-5">
            <h1 class="subtitulo2">
                Nuestra Gente
                <small>Conoce a las personas que forman parte de LOB.</small>
            </h1>

            <div class="row mt-5 mb-4 paginado">
                <div class="col-12 sinPadding">
                    @for($i=1; $i<=$parametros['paginas']; $i++)
                    <a href="{{ route('lista.contenidos', ['pagina' => $i]) }}" class="pagina {{ $parametros['pagina']==$i?'pagina-activa':'' }}"><span>{{ $i }}</span></a>
                    @endfor
                </div>
            </div>

            @foreach($parametros['contenidos'] as $key=>$value)
                <div class="col-3">
                    <div class="tarjetaCumple mb-4">
                        <div class="celdaCumple">
                            <div class="avatarCumple">
                                <img src="{{ $value['avatar']!=''?asset('storage/profiles/'.$value['avatar']):asset('media/usuario-perfil.jpg') }}" class="img-fluid" />
                            </div>
                            <h3 class="nombreCumple mt-3">
                                {{ $value['nombre'] }}
                                <span>{{ $value['puesto'] }}</span>
                            </h3>
                            <h4 class="deptoCumple mt-3">{{ $value['departamento'] }}</h4>
                            <button type="button" data-contenido="{{ $value['id'] }}" data-titulo="{{ cleanstring::cleanForUrl($value['nombre']) }}" class="btnCalendario mt-4">Saber más</button>
                        </div>
                    </div>
                </div>
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