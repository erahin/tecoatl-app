@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h1 class="text-center text-primary">Crear Proyecto.
                        </h1>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('proyectos.store') }}">
                            @csrf
                            <div class="row mb-3">
                                {!! Form::label('place', 'Lugar', ['class' => 'col-md-4 col-form-label text-md-end']) !!}
                                <div class="col-md-6">
                                    {!! Form::text('place', '', ['class' => 'form-control', 'autofocus', 'required', 'id' => 'place']) !!}
                                </div>
                            </div>
                            <div class="row mb-3">
                                {!! Form::label('abbreviation', 'Abreviación', ['class' => 'col-md-4 col-form-label text-md-end']) !!}
                                <div class="col-md-6">
                                    {!! Form::text('abbreviation', '', ['class' => 'form-control', 'required', 'id' => 'abbreviation']) !!}
                                </div>
                            </div>
                            <div class="row mb-3">
                                {!! Form::label('region_id', 'Regíon', ['class' => 'col-md-4 col-form-label text-md-end']) !!}
                                <div class="col-md-6">
                                    {!! Form::select('region_id', $regions, '', ['class' => 'form-select', 'id' => 'region_id', 'placeholder' => 'Seleccione Región']) !!}
                                </div>
                                {{-- <div class="col-md-6">
                                    {!! Form::select('region_id', $regions, $project->region_id, ['class' => 'form-select', 'id' => 'region_id', 'placeholder' => 'Seleccione Región']) !!}
                                </div> --}}
                            </div>
                            <div class="row mb-3">
                                {!! Form::label('studie_id', 'Estudios', ['class' => 'col-md-4 col-form-label text-md-end']) !!}
                                <div class="col-md-6">
                                    <div class="form-check form-check-inline ml-5">
                                        @foreach ($studies as $study)
                                            <label class="form-check-label inline_label">
                                                {!! Form::checkbox('studie_id[]', $study->id, null, ['class' => 'form-check-input']) !!}
                                                {{ $study->name }}
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                {!! Form::label('select', 'Informes', ['class' => 'col-md-4 col-form-label text-md-end']) !!}
                                <div class="col-md-6">
                                    {!! Form::file('name', ['class' => 'form-control', 'multiple', 'id' => 'select']) !!}
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
