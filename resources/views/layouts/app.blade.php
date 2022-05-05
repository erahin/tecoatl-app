<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('/img/favicon.svg') }}">
    <link rel="shortcut icon" sizes="192x192" href="{{ asset('/img/favicon.svg') }}">
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/script.js') }}" defer></script>
    <script src="https://kit.fontawesome.com/1934e005fb.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-3.6.0/dt-1.11.5/kt-2.6.4/datatables.min.js">
    </script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://use.typekit.net/saj3wiv.css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/v/dt/jq-3.6.0/dt-1.11.5/kt-2.6.4/datatables.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">


</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('inicio') }}" id="home">
                    {{-- {{ config('app.name', 'Laravel') }} --}}
                    <img src="{{ asset('img/serpiente_P5477-negativo.svg') }}" class="navbar__logo"
                        alt="Tecoatl Asesoría Ambiental y Soluciones Alternativas S.A De C.V">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto grt-menu">
                        <!-- Authentication Links -->
                        @guest
                        @if (Route::has('login'))
                        {{-- <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('INICIAR SESIÓN') }}</a>
                        </li> --}}
                        @endif

                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else
                        @can('directivo.index')
                        <li class="nav-item text-uppercase gtr-menu__li">
                            <a class="nav-link" href="{{ route('directivo.index') }}"><i class="fa fa-star"
                                    aria-hidden="true"></i>
                                {{ __('directivo') }}</a>
                        </li>
                        @endcan
                        @can('publico.index')
                        <li class="nav-item text-uppercase gtr-menu__li">
                            <a class="nav-link" href="{{ route('publico.index') }}"><i class="fa fa-users fa__li"
                                    aria-hidden="true"></i>
                                {{ __('Público') }}</a>
                        </li>
                        @endcan
                        @can('departaments.show')
                        <li class="nav-item dropdown text-uppercase">
                            <a id=" navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <i class="fa fa-building fa__li" aria-hidden="true"></i> {{ 'departamentos' }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                @can('administrativos.index')
                                <div class="gtr-menu__li">
                                    <a class="nav-link" href="{{ route('administrativos.index') }}"><i
                                            class="fa fa-book fa__li" aria-hidden="true"></i> {{
                                        __('Administración') }}</a>
                                </div>
                                @endcan
                                @can('legal.index')
                                <div class="gtr-menu__li">
                                    <hr class="dropdown-divider">
                                    <a class="nav-link" href="{{ route('legal.index') }}"><i
                                            class="fa fa-university fa__li" aria-hidden="true"></i>
                                        {{ __('legal') }}</a>
                                </div>
                                @endcan
                            </div>
                        </li>
                        @endcan
                        @can('proyectos.index')
                        <li class="nav-item dropdown text-uppercase">
                            <a id=" navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <i class="fa fa-book fa__li" aria-hidden="true"></i> {{ 'documentación' }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown"
                                id="dropdown-menu">
                            </div>
                        </li>
                        @endcan
                        @can('show.reports')
                        <li class="nav-item dropdown text-uppercase">
                            <a id=" navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <i class="fa fa-line-chart fa__li" aria-hidden="true"></i> {{ 'estatus de proyecto' }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <div class="gtr-menu__li">
                                    <a class="dropdown-item" href="{{ route('projectStart') }}">
                                        <i class="fa fa-hourglass-start" aria-hidden="true"></i>
                                        {{ __('proyectos por iniciar') }}
                                    </a>
                                </div>
                                <div class="gtr-menu__li">
                                    <hr class="dropdown-divider">
                                    <a class="dropdown-item" href="{{ route('projectInProcess') }}">
                                        <i class="fa fa-hourglass-half" aria-hidden="true"></i>
                                        {{ __('proyectos en proceso') }}
                                    </a>
                                </div>
                                <div class="gtr-menu__li">
                                    <hr class="dropdown-divider">
                                    <a class="dropdown-item" href="{{ route('completedProject') }}">
                                        <i class="fa fa-hourglass-end" aria-hidden="true"></i>
                                        {{ __('proyectos concluidos') }}
                                    </a>
                                </div>
                                {{-- <div class="gtr-menu__li">
                                    <hr class="dropdown-divider">
                                    <a class="dropdown-item" href="{{ route('showRegionForm') }}">
                                        <i class="fa fa-list-ol" aria-hidden="true"></i>
                                        {{ __('proyectos por región') }}
                                    </a>
                                </div> --}}
                                <div class="gtr-menu__li">
                                    <hr class="dropdown-divider">
                                    <a class="dropdown-item" href="{{ route('showPiechartbyRegion') }}">
                                        <i class="fa fa-pie-chart" aria-hidden="true"></i>
                                        {{ __('gráfica por región') }}
                                    </a>
                                </div>
                                <div class="gtr-menu__li">
                                    <hr class="dropdown-divider">
                                    <a class="dropdown-item" href="{{ route('reportWithUser') }}">
                                        <i class="fa fa-user-circle" aria-hidden="true"></i>
                                        {{ __('Informes por usuario') }}
                                    </a>
                                </div>
                                <div class="gtr-menu__li">
                                    <hr class="dropdown-divider">
                                    <a class="dropdown-item" href="{{ route('projectWithUser') }}">
                                        <i class="fa fa-user-circle" aria-hidden="true"></i>
                                        {{ __('proyectos por usuario') }}
                                    </a>
                                </div>
                            </div>
                        </li>
                        @endcan
                        @can('config')
                        <li class="nav-item dropdown text-uppercase">
                            <a id=" navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <i class="fa fa-cogs fa__li" aria-hidden="true"></i> {{ 'configuración' }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                @can('config')
                                <div class="gtr-menu__li">
                                    <a class="dropdown-item" href="{{ route('roles.index') }}">
                                        <i class="fa fa-tasks" aria-hidden="true"></i> {{ __('roles') }}
                                    </a>
                                </div>
                                @endcan
                                @can('config')
                                <div class="gtr-menu__li">
                                    <hr class="dropdown-divider">
                                    <a class="dropdown-item" href="{{ route('usuarios.index') }}">
                                        <i class="fa fa-users" aria-hidden="true"></i> {{ __('USUARIOS') }}
                                    </a>
                                </div>
                                @endcan
                                @can('config')
                                <div class="gtr-menu__li">
                                    <hr class="dropdown-divider">
                                    <a class="dropdown-item" href="{{ route('regiones.index') }}">
                                        <i class="fa fa-globe" aria-hidden="true"></i> {{ __('nueva región') }}
                                    </a>
                                </div>
                                @endcan
                                @can('config')
                                <div class="gtr-menu__li">
                                    <hr class="dropdown-divider">
                                    <a class="dropdown-item" href="{{ route('estudios.index') }}">
                                        <i class="fa fa-sitemap" aria-hidden="true"></i>
                                        {{ __('nueva categoría') }}
                                    </a>
                                </div>
                                @endcan
                            </div>
                        </li>
                        @endcan
                        <li class="nav-item dropdown text-uppercase">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <i class="fa fa-user-circle" aria-hidden="true"></i> {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fa fa-sign-out" aria-hidden="true"></i> {{ __('SALIR') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <style>
                main {
                    background-image: url('{{ asset('img/serpiente-Fatima.JPG') }}');
                    background-repeat: no-repeat;
                    background-position: 30% 60%;
                }

                @media (min-width: 768px) {
                    main {
                        background-image: url('{{ asset('img/serpiente-Fatima.JPG') }}');
                        background-repeat: repeat;
                        background-attachment: fixed;
                        background-position: center;
                    }
                }
            </style>
            @yield('content')
        </main>
    </div>
    @push('scripts')@stack('scripts')
</body>
@can('proyectos.index')
@if (!Auth::guest())
<script>
    /* -------------------------------------------------------------------------- */
    /*                                 Get regions                                */
    /* -------------------------------------------------------------------------- */
    (function() {
        if (localStorage.getItem("regions") != null) {
            let idRegions = localStorage.getItem("regions").split(",");
            let nameRegions = localStorage.getItem("namesRegions").split(",");
            const dropdown_menu = document.getElementById("dropdown-menu");
            let menu = "";
                for (let index = 0; index < idRegions.length; index++) {
                    if (index == (idRegions.length - 1)) {
                        menu += `<div class="gtr-menu__li menu-region">
                                    <a class="dropdown-item" href="/proyectos-por-region/${idRegions[index]}">
                                        <i class="fa fa-folder" aria-hidden="true"></i> región ${nameRegions[index]}
                                    </a>
                                </div>`;
                    } else {
                        menu += `<div class="gtr-menu__li menu-region">
                                    <a class="dropdown-item" href="/proyectos-por-region/${idRegions[index]}">
                                        <i class="fa fa-folder" aria-hidden="true"></i> región ${nameRegions[index]}
                                    </a>
                                    <hr class="dropdown-divider">
                                 </div>`;
                    }
                }
                dropdown_menu.innerHTML = menu;

        }
    })();
</script>
@endif
@endcan

</html>
