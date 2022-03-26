@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="row mb-3">
                        <img src="{{ asset('img/completo_positivo-negativo.svg') }}" class="header__logo"
                            alt="Tecoatl Asesoría Ambiental y Soluciones Alternativas S.A De C.V">
                    </div>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
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
                        <div class="d-flex flex-column mt-4 mb-2">
                            <div class="mb-2">
                                <span>{!! captcha_img('default') !!}</span>
                                <button type=" button" class="btn btn-secondary" class="reload" id="reload">
                                    &#x21bb;
                                </button>
                            </div>
                            <div class="captcha col-md-5">
                                <input id="captcha" type="text" class="form-control" placeholder="Captcha"
                                    name="captcha">
                                @error('captcha')
                                <strong class="text-danger text-center mt-5">{{ 'Escriba el captcha de
                                    nuevo ó correctamente'
                                    }}</strong>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{
                                        old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Recuérdame') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="">
                                <button type="submit" class="btn btn-primary button_login">
                                    <i class="fa fa-unlock-alt" aria-hidden="true"></i> {{ __('INGRESAR') }}
                                </button>

                                @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('¿OLVIDÓ SU CONTRASEÑA?') }}
                                </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    (function() {
            localStorage.removeItem("index");
            localStorage.removeItem("regionArray");
            localStorage.removeItem("namesRegions");
            localStorage.clear();
        })();
</script>
@endsection
@push('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
    $('#reload').click(function () {
        $.ajax({
            type: 'GET',
            url: 'reload-captcha',
            success: function (data) {
                $(".captcha span").html(data.captcha);
            }
        });
    });
</script>
@endpush
