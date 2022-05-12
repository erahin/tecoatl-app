@extends('layouts.app')

@section('content')
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
                    <form method="POST" action="{{ route('login') }}" class="body__form">
                        @csrf
                        <div class="input-group my-4">
                            <span class="input-group-text" id="basic-addon1"><i class="fa fa-user"></i></span>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required autocomplete="email"
                                placeholder="Correo Electrónico">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="input-group my-4">
                            <span class="input-group-text" id="basic-addon1"><i class="fa fa-lock"></i></span>
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror inputText" name="password"
                                required autocomplete="current-password" placeholder="Contraseña">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="input-group my-4">
                            <span class="input-group-text" id="basic-addon1"><i class="fa fa-mobile"
                                    aria-hidden="true"></i></span>
                            <input id="code" type="text" class="form-control @error('code') is-invalid @enderror"
                                name="code" value="{{ old('code') }}" required placeholder="Código">
                            @error('code')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <div class="">
                                <button type="submit" class="btn btn-primary button_login">
                                    <i class="fa fa-unlock-alt" aria-hidden="true"></i> {{ __('INGRESAR') }}
                                </button>
                                <a class="btn btn-link" href="{{ route('trySendCode') }}">
                                    {{ __('¿No has recibido el código?') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script>
    (function() {
            localStorage.removeItem("index");
            localStorage.removeItem("regionArray");
            localStorage.removeItem("namesRegions");
            localStorage.removeItem("a");
            localStorage.clear();
        })();
</script>
