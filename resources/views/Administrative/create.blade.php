@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h1 class="text-center">Crear departamento administrativo
                    </h1>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('administrativos.store') }}">
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
                            {!! Form::label('', 'Encargado', ['class' => 'col-md-4 col-form-label
                            text-md-end'])
                            !!}
                            <div class="col-md-6">
                                <div class="form-check scroll-studies">
                                    @foreach ($userArray as $user)
                                    <label class="form-check-label inline_label">
                                        {!! Form::checkbox('user_id[]', $user->id, null, ['class' =>
                                        'form-check-input']) !!}
                                        {{ $user->name }}
                                    </label>
                                    @endforeach
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
@endsection
