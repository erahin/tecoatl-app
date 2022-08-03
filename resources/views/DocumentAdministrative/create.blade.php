@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h1 class="text-center">Crear carpeta administrativa
                    </h1>
                    <h2 class="h6 text-center">Ruta: Administrativo/{{ $administrative->name }}/</h2>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('storeFolder', ['idAdministrative' => $idAdministrative]) }}"
                        id="form">
                        @csrf
                        @if ($directories)
                        @if (count($projects) > 0)
                        <div class="row mb-3">
                            {!! Form::label('', 'Carpetas creadas', ['class' => 'col-md-4 col-form-label text-md-end'])
                            !!}
                            <div class="col-md-6 scroll-studies">
                                <ul class="list-group">
                                    @foreach ($projects as $project)
                                    <li class="list-group-item">
                                        {!! Form::checkbox('directorie', $project, 'true', ['class' =>
                                        'form-check-input']) !!}
                                        {{ $project }} </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <hr>
                        @else
                        <div class="row mb-3">
                            {!! Form::label('', 'Carpetas creadas', ['class' => 'col-md-4 col-form-label text-md-end'])
                            !!}
                            <div class="col-md-6 scroll-studies">
                                <ul class="list-group">
                                    @foreach ($directories as $directorie)
                                    <li class="list-group-item">
                                        {!! Form::checkbox('directorie', $directorie, 'true', ['class' =>
                                        'form-check-input']) !!}
                                        {{explode('/', $directorie)[2]}} </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <hr>
                        @endif
                        @endif
                        <div class="row mb-3">
                            {!! Form::label('name', 'Nombre de la carpeta', ['class' => 'col-md-4 col-form-label
                            text-md-end']) !!}
                            <div class="col-md-6">
                                {!! Form::text('name', '', ['class' => 'form-control', 'autofocus', 'required',
                                'autofocus','id'=>'folder','onkeyup' => 'firstLetterToCapitalize(folder);'])
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
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                {{ Form::button('<i class="fa fa-plus" aria-hidden="true"></i> Crear', ['type' =>
                                'submit', 'class' =>
                                'btn btn-primary'] ) }}
                                <a class="btn btn-danger" href="{{ route('administrativos.index') }}"><i
                                        class="fa fa-ban" aria-hidden="true"></i> Cancelar
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
    const FOLDER_NAME = document.getElementById("folder");
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
