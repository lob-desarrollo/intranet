@extends('layouts.app')

@push('css')
    @vite(['resources/css/perfil.css'])
@endpush

@section('content')
    <section class="bannerPerfil" style="background: url('{{ asset('storage/profiles/'.$parametros['perfil']['fondo']) ?? asset('media/banner-perfil.jpg') }}') no-repeat center bottom;">
        <div class="cubiertaBanner">
            <div class="container">
                <div class="cajaUsuario">
                    <div class="imgUsuario">
                        <img src="{{ asset('storage/profiles/'.$parametros['perfil']['avatar']) ?? asset('media/usuario-perfil.jpg') }}" class="img-fluid" />
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
                    <a href="#" class="opcMenuPerfil perfilActivo"><span>Perfil</span></a>
                </li>
                <!--li>
                    <a href="#" class="opcMenuPerfil"><span>Perfil</span></a>
                </li-->
            </ul>
        </div>
    </section>
    <section class="my-5">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active pillsCustom" id="pills-general-tab" data-bs-toggle="pill" data-bs-target="#general" type="button" role="tab" aria-controls="pills-general" aria-selected="true">General</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link pillsCustom" id="pills-corporativo-tab" data-bs-toggle="pill" data-bs-target="#corporativo" type="button" role="tab" aria-controls="pills-corporativo" aria-selected="false">Corporativo</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="pills-general-tab">
                            <table class="table table-hover">
                                <tbody>
                                    <tr>
                                        <td>Nombre de usuario</td>
                                        <td>{{ $parametros['usuario']['name'] ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Nombre(s)</td>
                                        <td>{{ $parametros['perfil']['nombres'] ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Apellidos</td>
                                        <td>{{ $parametros['perfil']['apellidos'] ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Cumpleaños</td>
                                        <td class="txtMes">{{ \Carbon\Carbon::parse($parametros['perfil']['nacimiento'])->formatLocalized('%d.%B') ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Genero</td>
                                        <td>{{ $parametros['perfil']['genero'] ?? '' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="corporativo" role="tabpanel" aria-labelledby="pills-corporativo-tab">
                            <table class="table table-hover">
                                <tbody>
                                    <tr>
                                        <td>Puesto</td>
                                        <td>{{ $parametros['perfil']['puesto'] ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Ingreso</td>
                                        <td class="txtMes">{{ \Carbon\Carbon::parse($parametros['perfil']['ingreso'])->formatLocalized('%d.%B.%Y') ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Teléfono</td>
                                        <td class="maskMovil">{{ $parametros['perfil']['telefono'] ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Extension</td>
                                        <td>{{ $parametros['perfil']['extension'] ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Móvil</td>
                                        <td class="maskMovil">{{ $parametros['perfil']['movil'] ?? '' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            @if (Auth::user()->id == $parametros['usuario']['id'])
                <div class="card mt-4">
                    <div class="card-body">
                        <form id="password" method="post">
                            <div class="row g-3 align-items-center">
                                <div class="col-auto">
                                    <label for="clave" class="col-form-label">Nueva contraseña</label>
                                </div>
                                <div class="col-auto">
                                    <input type="password" id="clave" name="clave" class="form-control" required="true" data-tipo="txt" aria-describedby="passwordHelpInline">
                                </div>
                                <div class="col-auto">
                                    <span id="passwordHelpInline" class="form-text">
                                    No menor a 8 caracteres.
                                    </span>
                                </div>
                                <div class="col-auto">
                                    <button type="button" data-clave="cambiar" class="btn btn-dark"><i class="fas fa-save me-1"></i> Cambiar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection

@push('script')
    <script src="{{ asset('js/jquery-mask/dist/jquery.mask.min.js') }}"></script>
    <script src="{{ asset('js/perfil.js').'?r='.time() }}"></script>
    <script>
        (function($) {
            perfil.init();
        })(jQuery);
    </script>
@endpush