@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h1 class="text-center">Subir archivo
                    </h1>
                    <h2 class="h6 text-center">Ruta: <span class="text-capitalize">{{ $path }}/</span></h2>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('legal.upload', ['path' => str_replace('/', '-', $path)]) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @if ($files)
                        <div class="row mb-3">
                            {!! Form::label('', 'Archivos subidos', ['class' => 'col-md-4 col-form-label text-md-end'])
                            !!}
                            <div class="col-md-6 scroll-studies">
                                <ul class="list-group">
                                    @foreach ($files as $file)
                                    <li class="list-group-item">
                                        {!! Form::checkbox('files[]', $file, 'true', ['class' =>
                                        'form-check-input']) !!}
                                        {{explode('/', $file)[$index+1]}} </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <hr>
                        @endif
                        <div class="row mb-3">
                            {!! Form::label('files', 'Subir archivos', ['class' => 'col-md-4 col-form-label
                            text-md-end'])
                            !!}
                            <div class="col-md-6">
                                {!! Form::file('files-upload[]', ['class' => 'form-control', 'multiple', 'id' =>
                                'select',
                                'required', 'title' => 'Subir archivos']) !!}
                                @error('files-upload')
                                <strong class="text-danger text-center mt-5">{{ $message
                                    }}</strong>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                {{ Form::button('<i class="fa fa-upload" aria-hidden="true"></i> Subir', ['type' =>
                                'submit', 'class' =>
                                'btn btn-primary'] ) }}
                                @if (count($array) == 2)
                                <a class="btn btn-danger" href="{{ route('legal.index') }}"><i class="fa fa-ban"
                                        aria-hidden="true"></i> Cancelar
                                </a>
                                @else
                                <a class="btn btn-danger"
                                    href="{{ route('legal.folder-list', ['path' => str_replace('/', '-', $previousPath)]) }}"><i
                                        class="fa fa-ban" aria-hidden="true"></i> Cancelar
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
@endsection
