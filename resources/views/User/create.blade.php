@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h1 class="text-center text-primary">Crear Usuario.
                    </h1>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('usuarios.store') }}">
                        @csrf
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Nombre') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Dirección de correo
                                electrónico') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Contraseña')
                                }}</label>
                            <div class="col-md-6">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    required autocomplete="new-password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirmar
                                contraseña') }}</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" required autocomplete="new-password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="key" class="col-md-4 col-form-label text-md-end">{{__('Llave')
                                }}</label>
                            <div class="col-md-6 d-flex flex-row">
                                <div class="col-md-4 ancla">
                                    <input id="user_key" type="text"
                                        class="form-control @error('user_key') is-invalid @enderror ml-2"
                                        name="user_key" required>
                                </div>
                                <a href="" class="btn btn-secondary" id="reload" title="Generar llave">&#x21bb;</a>
                                @error('user_key')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            {!! Form::label('roles', 'Roles', ['class' => 'col-md-4 col-form-label text-md-end']) !!}
                            <div class="col-md-6">
                                <div class="form-check scroll-roles">
                                    @foreach ($roles as $rol)
                                    <label class="form-check-label inline_label">
                                        {!! Form::checkbox('roles[]', $rol->id, null, ['class' => 'form-check-input',
                                        'id' => $rol->id]) !!}
                                        {{ $rol->name }}
                                    </label>
                                    @endforeach
                                </div>
                                @error('roles')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ 'Seleccione al menos un rol' }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                {{ Form::button('<i class="fa fa-plus" aria-hidden="true"></i> Crear', ['type' =>
                                'submit', 'class' =>
                                'btn btn-primary'] ) }}
                                <a class="btn btn-danger" href="{{ route('usuarios.index') }}"><i class="fa fa-ban"
                                        aria-hidden="true"></i>
                                    Cancelar
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    let reload = document.getElementById("reload");
    reload.addEventListener('click', (e) => {
        e.preventDefault();
        let rand = Math.random().toString(16).substr(2, 8);
        document.getElementById("user_key").value = rand;
    });
</script>
@endsection
