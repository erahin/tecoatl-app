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
                                {!! Form::label('name', 'Nombre', ['class' => 'col-md-4 col-form-label text-md-end']) !!}
                                <div class="col-md-6">
                                    {!! Form::text('name', $region->name, ['class' => 'form-control', 'required', 'autofocus']) !!}
                                </div>
                            </div>
                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    {!! Form::submit('Modificar', ['class' => 'btn btn-primary']) !!}
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
