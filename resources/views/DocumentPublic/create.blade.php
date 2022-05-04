@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h1 class="text-center">Crear carpeta
                    </h1>
                    <h2 class="h6 text-center">Ruta: {{ str_replace('-', '/', $path) }}/</h2>
                </div>
                <div class="card-body">
                    <form method="POST"
                        action="{{ route('publico.store', ['path' => str_replace('/', '-', $path), 'route' => 'publico.index']) }}">
                        @csrf
                        @if ($folders)
                        <div class="row mb-3">
                            {!! Form::label('', 'Carpetas creadas', ['class' => 'col-md-4 col-form-label text-md-end'])
                            !!}
                            <div class="col-md-6 scroll-studies">
                                <ul class="list-group">
                                    @foreach ($folders as $folder)
                                    <li class="list-group-item">
                                        {!! Form::checkbox('directorie', $folder, 'true', ['class' =>
                                        'form-check-input']) !!}
                                        {{ explode('/', $folder)[$index+1] }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <hr>
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
                                <a class="btn btn-danger" href="{{ route('publico.index') }}"><i class="fa fa-ban"
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
@endsection
