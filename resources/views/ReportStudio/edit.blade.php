@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h1 class="text-center text-primary">Editar Informe {{ $report->report_number }}.
                    </h1>
                </div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <form method="POST" action="{{ route('informes.update', $report->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @if ($files)
                        <div class="row mb-3">
                            {!! Form::label('', 'Archivos subidos', ['class' => 'col-md-4 col-form-label text-md-end'])
                            !!}
                            <div class="col-md-6 scroll-studies">
                                <ul class="list-group">
                                    @foreach ($files as $file)
                                    {{-- @foreach ($directory as $file) --}}
                                    <li class="list-group-item">
                                        {!! Form::checkbox('files[]', $file, 'true', ['class' =>
                                        'form-check-input']) !!}
                                        {{explode('/', $file)[7]}} </li>
                                    {{-- @endforeach --}}
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
                            <div class="col-md-6">
                                {!! Form::number('report_number', $report->report_number , ['class' =>
                                'form-control','required']) !!}
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
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="report_type" class="col-md-4 col-form-label text-md-end">Tipo de reporte</label>
                            <div class="col-md-6">
                                <select name="report_type" class="form-select">
                                    <option value="">Seleccione</option>
                                    @if ($report->report_type == "Bimestral")
                                    <option value="Bimestral" selected>Bimestral</option>
                                    <option value="Anual">Anual</option>
                                    @else
                                    <option value="Bimestral">Bimestral</option>
                                    <option value="Anual" selected>Anual</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            {!! Form::label('start_date' ,'Fecha inicio', [
                            'class' => 'col-md-4 col-form-label
                            text-md-end',
                            ]) !!}
                            <div class="col-md-6">
                                {!! Form::date('start_date', $report->start_date, ['class' => 'form-control',
                                'required']) !!}
                            </div>
                        </div>
                        <div class="row mb-3">
                            {!! Form::label('end_date', 'Fecha final', [
                            'class' => 'col-md-4 col-form-label
                            text-md-end',
                            ]) !!}
                            <div class="col-md-6">
                                {!! Form::date('end_date', $report->end_date, ['class' => 'form-control', 'required'])
                                !!}
                            </div>
                        </div>
                        <div class="row mb-3">
                            {!! Form::label('select', 'Informes', ['class' => 'col-md-4 col-form-label text-md-end'])
                            !!}
                            <div class="col-md-6">
                                {!! Form::file('reports[]', ['class' => 'form-control', 'multiple', 'id' => 'select',
                                'required']) !!}
                            </div>
                        </div>
                        {!! Form::number('user_id', Auth::user()->id, ['class' => 'form-control', 'hidden', 'required'])
                        !!}
                        {!! Form::number('project_id', $project->id, ['class' => 'form-control', 'hidden', 'required'])
                        !!}
                        {!! Form::number('studio_id', $idStudio, ['class' => 'form-control', 'hidden', 'required']) !!}
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                {!! Form::submit('Editar', ['class' => 'btn btn-primary']) !!}
                                <a class="btn btn-danger"
                                    href="{{ route('reports-list',[ 'id' => $project->id, 'idStudio' => $idStudio]) }}">Cancelar
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
