@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h1 class="text-center">Crear rol
                    </h1>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('roles.store') }}" id="form">
                        @csrf
                        <div class="row mb-3">
                            {!! Form::label('', 'Nombre del rol', ['class' => 'col-md-4 col-form-label
                            text-md-end']) !!}
                            <div class="col-md-6">
                                {!! Form::text('name', '', ['class' => 'form-control', 'autofocus', 'required',
                                'autofocus', 'id' => 'rol', 'onkeyup' => 'firstLetterToCapitalize(rol);']) !!}
                                @error('name')
                                <strong class="text-danger text-center mt-5">{{ $message
                                    }}</strong>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            {!! Form::label('name', 'Confirmar nombre', ['class' => 'col-md-4
                            col-form-label
                            text-md-end']) !!}
                            <div class="col-md-6">
                                {!! Form::text('name_confirmation', '', ['class' => 'form-control', 'autofocus',
                                'required',
                                'autofocus','id'=>'name_confirmation','onkeyup' =>
                                'firstLetterToCapitalize(name_confirmation);'])
                                !!}
                                @error('name_confirmation')
                                <strong class="text-danger text-center mt-5">{{ $message
                                    }}</strong>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            {!! Form::label('permissions', 'Permisos', ['class' => 'col-md-4 col-form-label
                            text-md-end']) !!}
                            <div class="col-md-6">
                                <div class="form-check scroll-permissions">
                                    @foreach ($permissions as $permission)
                                    <label class="form-check-label inline_label" required>
                                        {!! Form::checkbox('permissions[]', $permission->id, null, ['class' =>
                                        'form-check-input',
                                        'id' => $permission->id])
                                        !!}
                                        {{ $permission->description }}
                                    </label>
                                    @endforeach
                                </div>
                                @error('permissions')
                                <strong class="text-danger text-center mt-5">{{ $message
                                    }}</strong>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                {{ Form::button('<i class="fa fa-plus" aria-hidden="true"></i> Crear', ['type' =>
                                'submit', 'class' =>
                                'btn btn-primary', 'id' => 'btn-submit'] ) }}
                                <a class="btn btn-danger" href="{{ route('roles.index') }}"><i class="fa fa-ban"
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
{{-- <script>
    const button = document.getElementById('btn-submit');
    button.addEventListener('click', function (e) {
        let rol = document.getElementById('rol').value;
        if(rol){
            if (!window.confirm('¿Desea confirmar el nombre del rol? Una ves agregado no se podrá modificar el nombre')) {
                e.preventDefault();
            }
        }
    });
</script> --}}
@endsection
