<!doctype html>
<html id="inicio" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>{{ config('app.name', 'LOB') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="Intranet corporativo" name="description" />
    <meta content="FN" name="author" />
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/css/variables.css', 'resources/css/app.css'])
    @stack('css')
</head>
<body class="bg-white">
    <div class="pantalla">
        <div class="pant">
            <div class="loader"></div>
        </div>
    </div>

    <div class="bloqueMenu">
        <div class="menuLateral">
            <div class="encabezadoLateral">
                <button type="button" id="closeMenu" class="btnCloseMenu"><i class="fal fa-times"></i></button>
                <div class="logoLateral">
                    <a href="{{ url('/') }}"><img src="{{ asset('media/lob-blanco-sin-fondo.png') }}" class="img-fluid" alt="{{ config('app.name', 'Laravel') }}" /></a>
                </div>
            </div>
            <nav class="menuSecciones">
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-comunidad" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Comunidad</button>
                    @if (!Auth::guest())
                        @if (Auth::user()->hasRole('sa') || Auth::user()->hasRole('admin'))
                            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-administracion" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Administración</button>
                        @endif
                    @endif
                </div>
            </nav>
            <div class="zonaScroll">
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-comunidad" role="tabpanel" aria-labelledby="nav-home-tab">
                        <ul class="listaMenuLateral">
                            <li>
                                <a href="{{ url('/') }}" class="enlaceMenuLateral">
                                    <span class="lineaEnlace"><span></span></span>
                                    <span class="tituloEnlace">
                                        <i class="fas fa-home-alt"></i> Inicio
                                    </span>
                                </a>
                            </li>
                            @if (!Auth::guest())
                                @if (Auth::user()->hasRole('sa') || Auth::user()->hasRole('admin') || Auth::user()->hasRole('user'))
                            <li>
                                <a href="{{ route('lista.avisos', ['pagina' => 1]) }}" class="enlaceMenuLateral">
                                    <span class="lineaEnlace"><span></span></span>
                                    <span class="tituloEnlace">
                                        <i class="fas fa-ad"></i> Avisos
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('enlaces.index') }}" class="enlaceMenuLateral">
                                    <span class="lineaEnlace"><span></span></span>
                                    <span class="tituloEnlace">
                                        <i class="fas fa-link"></i> Enlaces de interés
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('lista.contenidos', ['pagina' => 1]) }}" class="enlaceMenuLateral">
                                    <span class="lineaEnlace"><span></span></span>
                                    <span class="tituloEnlace">
                                        <i class="fas fa-book-reader"></i> Nuestra Gente
                                    </span>
                                </a>
                            </li>
                                @endif
                            @endif
                        </ul>  
                    </div>
                    @if (!Auth::guest())
                        @if (Auth::user()->hasRole('sa') || Auth::user()->hasRole('admin'))
                    <div class="tab-pane fade" id="nav-administracion" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <ul class="listaMenuLateral">
                            <li>
                                <a href="dropDown" class="enlaceMenuLateral">
                                    <span class="lineaEnlace"><span></span></span>
                                    <span class="tituloEnlace">
                                        <i class="far fa-chevron-right float-end mt-1"></i>
                                        <i class="fas fa-ad"></i> Avisos
                                    </span>
                                </a>
                                <ul class="subMenuLateral">
                                    <li><a href="{{ route('admin.aviso.index') }}" class="opcionLateral"><i class="fas fa-circle me-1"></i><span>Publicar Avisos</span></a></li>
                                    <li><a href="{{ route('admin.avisocategoria.index') }}" class="opcionLateral"><i class="fas fa-circle me-1"></i><span>Categorías</span></a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="dropDown" class="enlaceMenuLateral">
                                    <span class="lineaEnlace"><span></span></span>
                                    <span class="tituloEnlace">
                                        <i class="far fa-chevron-right float-end mt-1"></i>
                                        <i class="fas fa-link"></i> Enlaces
                                    </span>
                                </a>
                                <ul class="subMenuLateral">
                                    <li><a href="{{ route('admin.link.index') }}" class="opcionLateral"><i class="fas fa-circle me-1"></i><span>Publicar Enlaces</span></a></li>
                                    <li><a href="{{ route('admin.linkcategoria.index') }}" class="opcionLateral"><i class="fas fa-circle me-1"></i><span>Categorías</span></a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="{{ route('admin.contenido.index') }}" class="enlaceMenuLateral">
                                    <span class="lineaEnlace"><span></span></span>
                                    <span class="tituloEnlace">
                                        <i class="fas fa-book-reader"></i> Nuestra Gente
                                    </span>
                                </a>
                            </li>
                        </ul> 
                    </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>    
    </div>
    
    <div class="barraTop">
        <button type="button" id="openMenu" class="btnMenu"><i class="fal fa-bars"></i></button>
        <a href="{{ url('/') }}" class="btnlogo" title="{{ config('app.name', 'Laravel') }}"><img src="{{ asset('media/lob.png') }}" class="img-fluid" alt="{{ config('app.name', 'Laravel') }}" /></a>
        <ul class="menu">
            <li><a href="{{ url('/lob/nosotros') }}" class="opcmenu"><span>Nosotros</span></a></li>
            <!--li class="dropDown">
                <a href="{{ url('/') }}" class="opcmenu"><span>Nosotros <i class="fas fa-angle-down ms-1"></i></span></a>
                <ul class="submenu">
                    <li><a href=""><span>Valores</span></a></li>
                    <li><a href=""><span>Reconocimientos</span></a></li>
                </ul>
            </li>
            <li><a href="{{ url('/') }}" class="opcmenu"><span>Valores</span></a></li-->
            @guest
                @if (Route::has('login'))
                    <li><a href="{{ route('login') }}" class="btnLogin" title="Ingreso"><span>Ingreso</span></a></li>
                @endif
            @else
                <li class="dropDown">
                    <a href="{{ url('/') }}" class="opcmenu"><span><i class="fal fa-user me-1"></i> {{ Auth::user()->name }} <i class="fas fa-angle-down ms-1"></i></span></a>
                    <ul class="submenu">
                        <li>
                            <a href="{{ route('perfiles.index') }}"><span>Perfil</span></a>
                        </li>
                        <li>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><span>Salir</span></a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
            @endguest
        </ul>
    </div>

    <div id="app" class="topMargen">
        <main>
            @yield('content')
        </main>
    </div>

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-3">
                    <img src="{{ asset('media/lob.jpg') }}" class="img-fluid" />
                </div>
                <div class="col-3">
                    <ul class="menuFooter">
                        <li><h4 class="menuTituloFooter">ACERCA DE LOB</h4></li>
                        <li><a href="{{ url('/lob/nosotros') }}" class="btnMenuFooter"><span>Nosotros</span></a></li>
                    </ul>
                </div>
                <!--div class="col-3">
                    <ul class="menuFooter">
                        <li><h4 class="menuTituloFooter">VESTIBULUM PULVINAR</h4></li>
                        <li><a href="" class="btnMenuFooter"><span>Etiam aliquet</span></a></li>
                        <li><a href="" class="btnMenuFooter"><span>Suspendisse</span></a></li>
                        <li><a href="" class="btnMenuFooter"><span>Pellentesque</span></a></li>
                    </ul>
                </div>
                <div class="col-3">
                    <ul class="menuFooter">
                        <li><h4 class="menuTituloFooter">VESTIBULUM PULVINAR</h4></li>
                        <li><a href="" class="btnMenuFooter"><span>Etiam aliquet</span></a></li>
                        <li><a href="" class="btnMenuFooter"><span>Suspendisse</span></a></li>
                        <li><a href="" class="btnMenuFooter"><span>Pellentesque</span></a></li>
                    </ul>
                </div-->
            </div>
        </div>
    </footer>
    <div class="barraBottom">
        <div class="container">
            <div class="row">
                <div class="col-6">
                    <div class="derechos"><span>&copy;2024 Operdaroda LOB</span></div>
                </div>
                <div class="col-6">
                    <div class="redes">
                        <a href="https://www.facebook.com/lob.com.mx" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://www.instagram.com/lobmoda/" target="_blank"><i class="fab fa-instagram"></i></a>
                    </div>  
                </div>
            </div>
        </div>
    </div>

    <a href="#inicio" class="botonSubir"><span><i class="fas fa-chevron-up"></i></span></a>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/principal.js').'?r='.time() }}"></script>
    @vite(['resources/js/app.js'])
    <script>
        (function($) {
            principal.init();
        })(jQuery);
    </script>
    @stack('script')
</body>
</html>