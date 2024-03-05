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
    <div class="barraTop">
        <button type="button" id="openMenu" class="btnMenu"><i class="fal fa-bars"></i></button>
        <a href="{{ url('/') }}" class="btnlogo" title="{{ config('app.name', 'Laravel') }}"><img src="{{ asset('img/lob.png') }}" class="img-fluid" alt="{{ config('app.name', 'Laravel') }}" /></a>
        <a href="{{ route('login') }}" class="btnLogin" title="Ingreso"><span>Ingreso</span></a>
        <ul class="menu">
            <li><a href="{{ url('/') }}" class="opcmenu"><span>Nosotros</span></a></li>
            <li><a href="{{ url('/') }}" class="opcmenu"><span>Valores</span></a></li>
            <li><a href="{{ url('/') }}" class="opcmenu"><span>Reconocimientos</span></a></li>
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
                    <img src="{{ asset('img/lob.jpg') }}" class="img-fluid" />
                </div>
                <div class="col-3">
                    <ul class="menuFooter">
                        <li><h4 class="menuTituloFooter">ACERCA DE LOB</h4></li>
                        <li><a href="" class="btnMenuFooter"><span>Nosotros</span></a></li>
                        <li><a href="" class="btnMenuFooter"><span>Valores</span></a></li>
                        <li><a href="" class="btnMenuFooter"><span>Reconocimientos</span></a></li>
                    </ul>
                </div>
                <div class="col-3">
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
                </div>
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
                        <a href=""><i class="fab fa-facebook-f"></i></a>
                        <a href=""><i class="fab fa-instagram"></i></a>
                    </div>  
                </div>
            </div>
        </div>
    </div>

    <a href="#inicio" class="botonSubir"><span><i class="fas fa-chevron-up"></i></span></a>
    <script src="{{ asset('js/jquery.js') }}"></script>
    @vite(['resources/js/app.js', 'resources/js/principal.js'])
</body>
</html>
