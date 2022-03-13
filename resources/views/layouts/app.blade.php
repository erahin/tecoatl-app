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
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/v/dt/jq-3.6.0/dt-1.11.5/kt-2.6.4/datatables.min.css" />

    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-3.6.0/dt-1.11.5/kt-2.6.4/datatables.min.js">
    </script>

</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
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
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @endif

                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else
                        {{-- @can('')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('') }}">{{ __('') }}</a>
                        </li>
                        @endcan --}}
                        @can('proyectos.index')
                        <li class="nav-item text-uppercase">
                            <a class="nav-link" href="{{ route('proyectos.index') }}">{{ __('proyectos') }}</a>
                        </li>
                        @endcan
                        @can('estudios.index')
                        <li class="nav-item text-uppercase">
                            <a class="nav-link" href="{{ route('estudios.index') }}">{{ __('estudios') }}</a>
                        </li>
                        @endcan
                        @can('regiones.index')
                        <li class="nav-item text-uppercase">
                            <a class="nav-link" href="{{ route('regiones.index') }}">{{ __('regiones') }}</a>
                        </li>
                        @endcan
                        @can('usuarios.index')
                        <li class="nav-item text-uppercase">
                            <a class="nav-link" href="{{ route('usuarios.index') }}">{{ __('USUARIOS') }}</a>
                        </li>
                        @endcan
                        @can('roles.index')
                        <li class="nav-item text-uppercase">
                            <a class="nav-link" href="{{ route('roles.index') }}">{{ __('roles') }}</a>
                        </li>
                        @endcan
                        @can('show.reports')
                        <li class="nav-item dropdown text-uppercase">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ 'REPORTES'}}
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('projectStart') }}">
                                    {{ __('proyectos por iniciar') }}
                                </a>
                                <hr class="dropdown-divider">
                                <a class="dropdown-item" href="{{ route('projectInProcess') }}">
                                    {{ __('proyectos en proceso') }}
                                </a>
                                <hr class="dropdown-divider">
                                <a class="dropdown-item" href="{{ route('completedProject') }}">
                                    {{ __('proyectos concluidos') }}
                                </a>
                            </div>
                        </li>
                        @endcan
                        <li class="nav-item dropdown text-uppercase">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                                                                                                                                                                         document.getElementById('logout-form').submit();">
                                    {{ __('SALIR') }}
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
            @yield('content')
        </main>
    </div>
</body>

</html>
