@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h1 class="text-center text-primary">Modificar Región.
                    </h1>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('regiones.update', $region->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            {!! Form::label('name', 'Nombre de la región', ['class' => 'col-md-4 col-form-label
                            text-md-end']) !!}
                            <div class="col-md-6">
                                {!! Form::text('name', $region->name, ['class' => 'form-control', 'required',
                                'autofocus']) !!}
                                @error('name')
                                <strong class="text-danger text-center mt-5">{{ 'El campo nombre de la región es
                                    obligatorio'
                                    }}</strong>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                {!! Form::submit('Modificar', ['class' => 'btn btn-primary']) !!}
                                <a class="btn btn-danger" href="{{ route('regiones.index') }}">Cancelar
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
