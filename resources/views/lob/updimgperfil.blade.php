@extends('layouts.app')

@push('css')
    @vite(['resources/css/perfil.css'])
@endpush

@section('content')
    <section class="bannerPerfil" style="background: url('{{ $parametros['perfil']['fondo']!=''?asset('storage/profiles/'.$parametros['perfil']['fondo']):asset('media/banner-perfil.jpg') }}') no-repeat center bottom;">
        <div class="cubiertaBanner">
            <div class="container">
                <div class="cajaUsuario">
                    <div class="imgUsuario">
                        <img src="{{ $parametros['perfil']['avatar']!=''?asset('storage/profiles/'.$parametros['perfil']['avatar']):asset('media/usuario-perfil.jpg') }}" class="img-fluid" />
                    </div>
                    <div class="datosUsuario">
                        <h3>{{ $parametros['usuario']['name'] }}</h3>
                        <span>{{ $parametros['perfil']['puesto'] ?? '' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="cMenuPerfil">
        <div class="container">
            <ul class="menuPerfil">
                <li>
                    <a href="#" class="opcMenuPerfil perfilActivo"><span>{{ $parametros['titulo'] }}</span></a>
                </li>
                <!--li>
                    <a href="#" class="opcMenuPerfil"><span>Perfil</span></a>
                </li-->
            </ul>
            
        </div>
    </section>
    <section class="my-5">
        <div class="container">
            <form id="upd" action="{{ $parametros['urlGuardar'] }}" method="post" enctype="multipart/form-data" autocomplete="off">
                @csrf

                <div class="row">
                    <div class="col-md-4">
                        <label for="imagen">Imagen</label>
                        <input type="file" name="imagen" id="imagen" class="form-control" required="true" data-tipo="txt" onchange="perfil.imagen(this);" />
                        <small>Tamaño: {{ $parametros['size'] }} pixeles</small>
                    </div>
                    <div class="col-md-4">
                        <div class="ejemploImg">
                            @if(isset($parametros['datos']['imagen']))
                            <img id="ejemplo" src="{{ asset('storage/profiles/'.$parametros['datos']['imagen']) }}" class="img-fluid" />
                            @else
                            <img id="ejemplo" src="{{ asset('media/imagen_ejemplo.png') }}" class="img-fluid" />
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <button type="button" data-accion="guardar" class="btn btn-dark"><i class="fas fa-save me-1"></i> Guardar</button>
                        <button type="button" data-accion="cancelar" class="btn btn-secondary ms-3"><i class="fal fa-times me-1"></i> Cancelar</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection

@push('script')
    <script src="{{ asset('js/jquery-mask/dist/jquery.mask.min.js') }}"></script>
    <script src="{{ asset('js/perfil.js').'?r='.time() }}"></script>
    <script>
        (function($) {
            perfil.formulario('{{ $parametros['urlCancelar'] }}');
        })(jQuery);
    </script>
@endpush