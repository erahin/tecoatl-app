@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h1 class="text-center text-primary">Crear Informe.
                    </h1>
                </div>
                <div class="card-body">
                    <form method="POST" action="">
                        @csrf
                        <div class="row mb-3">
                            {!! Form::label('report_number', 'Número de informe', ['class' => 'col-md-4 col-form-label
                            text-md-end']) !!}
                            <div class="col-md-6">
                                {!! Form::number('report_number', '', ['class' => 'form-control', 'autofocus',
                                'required',
                                'autofocus']) !!}
                            </div>
                        </div>
                        <div class="row mb-3">
                            {!! Form::label('project_id', 'Proyecto', ['class' => 'col-md-4 col-form-label
                            text-md-end']) !!}
                            <div class="col-md-6">
                                {!! Form::text('project_id', $project->place, ['class' => 'form-control',
                                'required', 'disabled']) !!}
                            </div>
                        </div>
                        <div class="row mb-3">
                            {!! Form::label('start_date', 'Fecha inicio', ['class' => 'col-md-4 col-form-label
                            text-md-end']) !!}
                            <div class="col-md-6">
                                {!! Form::date('start_date','', ['class' => 'form-control',
                                'required']) !!}
                            </div>
                        </div>
                        <div class="row mb-3">
                            {!! Form::label('end_date', 'Fecha final', ['class' => 'col-md-4 col-form-label
                            text-md-end']) !!}
                            <div class="col-md-6">
                                {!! Form::date('end_date','', ['class' => 'form-control',
                                'required']) !!}
                            </div>
                        </div>
                        <div class="row mb-3">
                            {!! Form::label('file', 'Informes', ['class' => 'col-md-4 col-form-label text-md-end'])
                            !!}
                            <div class="col-md-6">
                                {!! Form::file('file[]', ['class' => 'form-control', 'multiple', 'id' => 'select',
                                'required']) !!}
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
