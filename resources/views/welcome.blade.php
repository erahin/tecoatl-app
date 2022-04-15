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
                <a class="navbar-brand" href="#" id="welcome">
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
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <div class="row mb-3">
                                    <img src="{{ asset('img/completo_P5477-negativo.svg') }}" class="header__logo"
                                        alt="Tecoatl Asesoría Ambiental y Soluciones Alternativas S.A De C.V">
                                </div>
                            </div>

                            <div class="card-body">
                                <form method="GET" action="{{ route('sendCode') }}" class="body__form">
                                    <div class="input-group my-4">
                                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-mobile"
                                                aria-hidden="true"></i></span>
                                        <input id="phone" type="number"
                                            class="form-control @error('phone') is-invalid @enderror" name="phone"
                                            value="{{ old('phone') }}" required placeholder="9516129964">
                                        @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <div class="">
                                            <button type="submit" class="btn btn-primary button_login">
                                                <i class="fa fa-envelope" aria-hidden="true"></i> {{ __('ENVIAR') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    @push('scripts')@stack('scripts')
</body>

</html>
