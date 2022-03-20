<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/script.js') }}" defer></script>
    <script src="https://kit.fontawesome.com/1934e005fb.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-3.6.0/dt-1.11.5/kt-2.6.4/datatables.min.js">
    </script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/v/dt/jq-3.6.0/dt-1.11.5/kt-2.6.4/datatables.min.css" />


</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}" id="home">
                    {{-- {{ config('app.name', 'Laravel') }} --}}
                    <img src="{{ asset('img/logo-tecoalt2.svg') }}" class="navbar__logo"
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
                            {{-- <script>
                                localStorage.setItem("regions", "{{ $regions }}");
                                let data = localStorage.getItem("regions");
                                data = data.split(",");
                                let array = [];
                                data.forEach((element, index) => {
                                    if (index === 0) {
                                        let id = element.charAt(1);
                                        array.push(id);
                                    }
                                    if (index === data.length) {
                                        let id = element.charAt(2);
                                        array.push(id);
                                    }
                                    array.push(element);

                                });
                                console.log(array);
                            </script> --}}
                            @can('proyectos.index')
                                <li class="nav-item dropdown text-uppercase">
                                    <a id=" navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        <i class="fa fa-book" aria-hidden="true"></i> {{ 'documentación' }}
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                        <div class="gtr-menu__li">
                                            <a class="dropdown-item" href="{{ route('projectStart') }}">
                                                <i class="fa fa-folder" aria-hidden="true"></i> {{ __('región norte') }}
                                            </a>
                                        </div>
                                        <div class="gtr-menu__li">
                                            <hr class="dropdown-divider">
                                            <a class="dropdown-item" href="{{ route('projectInProcess') }}">
                                                <i class="fa fa-folder" aria-hidden="true"></i> {{ __('región sur') }}
                                            </a>
                                        </div>
                                        <div class="gtr-menu__li">
                                            <hr class="dropdown-divider">
                                            <a class="dropdown-item" href="{{ route('projectInProcess') }}">
                                                <i class="fa fa-folder" aria-hidden="true"></i> {{ __('región centro') }}
                                            </a>
                                        </div>
                                    </div>
                                </li>
                            @endcan
                            {{-- @can('proyectos.index')
                                <li class="nav-item text-uppercase gtr-menu__li">
                                    <a class="nav-link"
                                        href="{{ route('proyectos.index') }}">{{ __('proyectos') }}</a>
                                </li>
                            @endcan --}}
                            {{-- @can('estudios.index')
                                <li class="nav-item text-uppercase gtr-menu__li">
                                    <a class="nav-link"
                                        href="{{ route('estudios.index') }}">{{ __('crear categoría') }}</a>
                                </li>
                            @endcan
                            @can('regiones.index')
                                <li class="nav-item text-uppercase gtr-menu__li">
                                    <a class="nav-link"
                                        href="{{ route('regiones.index') }}">{{ __('nueva región') }}</a>
                                </li>
                            @endcan
                            @can('usuarios.index')
                                <li class="nav-item text-uppercase gtr-menu__li">
                                    <a class="nav-link"
                                        href="{{ route('usuarios.index') }}">{{ __('USUARIOS') }}</a>
                                </li>
                            @endcan
                            @can('roles.index')
                                <li class="nav-item text-uppercase gtr-menu__li">
                                    <a class="nav-link" href="{{ route('roles.index') }}">{{ __('roles') }}</a>
                                </li>
                            @endcan --}}
                            @can('show.reports')
                                <li class="nav-item dropdown text-uppercase">
                                    <a id=" navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        <i class="fa fa-line-chart" aria-hidden="true"></i> {{ 'estatus de proyecto' }}
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
                                        <div class="gtr-menu__li">
                                            <hr class="dropdown-divider">
                                            <a class="dropdown-item" href="{{ route('showRegionForm') }}">
                                                <i class="fa fa-list-ol" aria-hidden="true"></i>
                                                {{ __('proyectos por región') }}
                                            </a>
                                        </div>
                                        <div class="gtr-menu__li">
                                            <hr class="dropdown-divider">
                                            <a class="dropdown-item" href="{{ route('showPiechartbyRegion') }}">
                                                <i class="fa fa-pie-chart" aria-hidden="true"></i>
                                                {{ __('gráfica por región') }}
                                            </a>
                                        </div>
                                    </div>
                                </li>
                            @endcan
                            @can('config')
                                <li class="nav-item dropdown text-uppercase">
                                    <a id=" navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        <i class="fa fa-cogs" aria-hidden="true"></i> {{ 'configuración' }}
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
                                        @endcan
                                        @can('config')
                                            <div class="gtr-menu__li">
                                                <hr class="dropdown-divider">
                                                <a class="dropdown-item" href="{{ route('estudios.index') }}">
                                                    <i class="fa fa-graduation-cap" aria-hidden="true"></i>
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
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4"
            style="background-image: url({{ asset('img/snake.jpg') }});background-repeat: repeat;">
            @yield('content')
        </main>
    </div>
</body>

</html>
