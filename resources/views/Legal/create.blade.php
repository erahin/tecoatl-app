@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h1 class="text-center">Crear departamento legal
                    </h1>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('legal.store') }}" id="form">
                        @csrf
                        <div class="row mb-3">
                            {!! Form::label('name', 'Nombre del departamento', ['class' => 'col-md-4 col-form-label
                            text-md-end']) !!}
                            <div class="col-md-6">
                                {!! Form::text('name', '', ['class' => 'form-control', 'autofocus', 'required',
                                'autofocus','id'=>'departament','onkeyup' => 'firstLetterToCapitalize(departament);'])
                                !!}
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
                            <label for="exampleFormControlSelect1"
                                class="col-md-4 col-form-label text-md-end">Encargado</label>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <select class="form-select" id="exampleFormControlSelect1" name="user_id">
                                        <option selected disabled value="">Escoja el encargado</option>
                                        @foreach ($userArray as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('user_id')
                                <strong class="text-danger text-center mt-5">{{ $message
                                    }}</strong>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                {{ Form::button('<i class="fa fa-plus" aria-hidden="true"></i> Crear', ['type' =>
                                'submit', 'class' =>
                                'btn btn-primary'] ) }}
                                <a class="btn btn-danger" href="{{ route('legal.index') }}"><i class="fa fa-ban"
                                        aria-hidden="true"></i> Cancelar
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
    const FOLDER_NAME = document.getElementById("departament");
    const FORM = document.getElementById("form");
    FORM.addEventListener("submit", (e) => {
        let name = FOLDER_NAME.value;
        let regExr = /-/;
        let res = regExr.test(name);
        if (res) {
            alert('El nombre incluye carácter "-" no válido');
            e.preventDefault();
        }
    });
</script>
@endsection
