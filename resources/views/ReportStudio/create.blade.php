@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h1 class="text-center">Agregar informe
                    </h1>
                </div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <div class="mb-3">
                        <h2 class="h6 text-center">Ruta: Técnico/{{ $project->regions->name }}/{{ $project->abbreviation
                            }}/{{ $studio->name }}
                        </h2>
                    </div>
                    <form method="POST" action="{{ route('informes.store') }}">
                        @csrf
                        @if (session('success'))
                        <h6 class="alert alert-warning">{{ session('success') }}</h6>
                        @endif
                        @if ($reports)
                        <div class="row mb-3" id="upload-reports">
                            {!! Form::label('', 'Informes subidos', ['class' => 'col-md-4 col-form-label text-md-end'])
                            !!}
                            <div class="col-md-6 scroll-studies">
                                <ul class="list-group">
                                    @foreach ($reports as $report)
                                    <li class="list-group-item">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="defaultCheck1"
                                                checked>
                                            <label class="form-check-label" for="defaultCheck1">
                                                {{ $report->name }}
                                            </label>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <hr>
                        @endif
                        <div class="row mb-3">
                            {!! Form::label('report_number', 'Número de informe', [
                            'class' => 'col-md-4 col-form-label
                            text-md-end',
                            ]) !!}
                            <div class=" col-md-6">
                                {!! Form::number('report_number', '', ['class' => 'form-control', 'autofocus',
                                'required', 'autofocus', 'min' => '1', 'pattern' => '^[1-9]+']) !!}
                                @error('report_number')
                                <strong class="text-danger text-center mt-5">{{ $message
                                    }}</strong>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            {!! Form::label('name', 'Nombre del informe', [
                            'class' => 'col-md-4 col-form-label
                            text-md-end',
                            ]) !!}
                            <div class=" col-md-6">
                                {!! Form::text('name', '', ['class' => 'form-control', 'autofocus',
                                'required', 'autofocus','id'=>'report','onkeyup' => 'firstLetterToCapitalize(report);'])
                                !!}
                                @error('name')
                                <strong class="text-danger text-center mt-5">{{ $message
                                    }}</strong>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            {!! Form::label('project_name', 'Proyecto', [
                            'class' => 'col-md-4 col-form-label
                            text-md-end',
                            ]) !!}
                            <div class="col-md-6">
                                {!! Form::text('project_name', $project->place, ['class' => 'form-control', 'required',
                                'disabled']) !!}
                                @error('project_name')
                                <strong class="text-danger text-center mt-5">{{ $message
                                    }}</strong>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            {!! Form::label('report_type', 'Tipo de reporte', ['class' => 'col-md-4 col-form-label
                            text-md-end'])
                            !!}
                            <div class="col-md-6">
                                {!! Form::select('report_type', $report_type, '', ['class' => 'form-select', 'id' =>
                                'status', 'placeholder' => 'Seleccione el tipo de reporte']) !!}
                                @error('report_type')
                                <strong class="text-danger text-center mt-5">{{ $message
                                    }}</strong>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            {!! Form::label('start_date', 'Fecha inicio', [
                            'class' => 'col-md-4 col-form-label
                            text-md-end',
                            ]) !!}
                            <div class="col-md-6">
                                {!! Form::date('start_date', '', ['class' => 'form-control', 'required']) !!}
                                @error('start_date')
                                <strong class="text-danger text-center mt-5">{{ $message
                                    }}</strong>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            {!! Form::label('end_date', 'Fecha final', [
                            'class' => 'col-md-4 col-form-label
                            text-md-end',
                            ]) !!}
                            <div class="col-md-6">
                                {!! Form::date('end_date', '', ['class' => 'form-control', 'required']) !!}
                                @error('end_date')
                                <strong class="text-danger text-center mt-5">{{ $message
                                    }}</strong>
                                @enderror
                            </div>
                        </div>
                        {!! Form::number('project_id', $project->id, ['class' => 'form-control', 'hidden', 'required'])
                        !!}
                        {!! Form::number('studio_id', $studio->id, ['class' => 'form-control', 'hidden', 'required'])
                        !!}
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                {{ Form::button('<i class="fa fa-plus-circle" aria-hidden="true"></i> Agregar', ['type'
                                =>
                                'submit', 'class' =>
                                'btn btn-primary'] ) }}
                                <a class="btn btn-danger" href="{{ route('studies-list', $project->id) }}"><i
                                        class="fa fa-ban" aria-hidden="true"></i>
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
@endsection
