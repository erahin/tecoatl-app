@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h1 class="text-center text-primary">Crear Rol.
                    </h1>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('roles.store') }}">
                        @csrf
                        <div class="row mb-3">
                            {!! Form::label('name', 'Nombre del rol', ['class' => 'col-md-4 col-form-label
                            text-md-end']) !!}
                            <div class="col-md-6">
                                {!! Form::text('name', '', ['class' => 'form-control', 'autofocus', 'required',
                                'autofocus']) !!}
                            </div>
                        </div>
                        <div class="row mb-3">
                            {!! Form::label('permissions[]', 'Permisos', ['class' => 'col-md-4 col-form-label
                            text-md-end']) !!}
                            <div class="col-md-6">
                                <div class="form-check scroll-permissions">
                                    @foreach ($permissions as $permission)
                                    <label class="form-check-label inline_label">
                                        {!! Form::checkbox('roles[]', $permission->id, null, ['class' =>
                                        'form-check-input',
                                        'id' => $permission->id])
                                        !!}
                                        {{ $permission->description }}
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                {!! Form::submit('Crear', ['class' => 'btn btn-primary']) !!}
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
