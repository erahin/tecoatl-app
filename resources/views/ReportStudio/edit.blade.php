@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h1 class="text-center">Editar informe <span class="header_span"> {{
                            $report_type[$report->report_type]}} </span>
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
                                    <li class="list-group-item">
                                        {!! Form::checkbox('files[]', $file, 'true', ['class' =>
                                        'form-check-input']) !!}
                                        {{explode('/', $file)[7]}} </li>
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
                                @error('report_number')
                                <strong class="text-danger text-center mt-5">{{ 'El campo número de informe es
                                    obligatorio'
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
                                {!! Form::text('name', $report->name, ['class' => 'form-control', 'autofocus',
                                'required', 'autofocus']) !!}
                                @error('name')
                                <strong class="text-danger text-center mt-5">{{ 'El campo nombre del informe es
                                    obligatorio'
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
                                <strong class="text-danger text-center mt-5">{{ 'El campo nombre del proyecto es
                                    obligatorio'
                                    }}</strong>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            {!! Form::label('report_type', 'Tipo de reporte', ['class' => 'col-md-4 col-form-label
                            text-md-end'])
                            !!}
                            <div class="col-md-6">
                                {!! Form::select('report_type', $report_type, $report->report_type, ['class' =>
                                'form-select', 'id' =>
                                'status', 'placeholder' => 'Seleccione el tipo de reporte']) !!}
                                @error('report_type')
                                <strong class="text-danger text-center mt-5">{{ 'Seleccione el tipo de reporte'
                                    }}</strong>
                                @enderror
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
                                @error('start_date')
                                <strong class="text-danger text-center mt-5">{{ 'El campo fecha inicio
                                    obligatorio'
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
                                {!! Form::date('end_date', $report->end_date, ['class' => 'form-control', 'required'])
                                !!}
                                @error('end_date')
                                <strong class="text-danger text-center mt-5">{{ 'El campo fecha final
                                    obligatorio'
                                    }}</strong>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            {!! Form::label('select', 'Subir archivos', ['class' => 'col-md-4 col-form-label
                            text-md-end'])
                            !!}
                            <div class="col-md-6">
                                {!! Form::file('reports[]', ['class' => 'form-control', 'multiple', 'id' => 'select',
                                'required']) !!}
                                @error('reports')
                                <strong class="text-danger text-center mt-5">{{ 'Suba al menos un archivo'
                                    }}</strong>
                                @enderror
                            </div>
                        </div>
                        {!! Form::number('user_id', Auth::user()->id, ['class' => 'form-control', 'hidden'])
                        !!}
                        {!! Form::number('project_id', $project->id, ['class' => 'form-control', 'hidden'])
                        !!}
                        {!! Form::number('studio_id', $idStudio, ['class' => 'form-control', 'hidden']) !!}
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                {{ Form::button('<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar',
                                ['type' =>
                                'submit', 'class' =>
                                'btn btn-primary'] ) }}
                                <a class="btn btn-danger"
                                    href="{{ route('reports-list',[ 'id' => $project->id, 'idStudio' => $idStudio]) }}"><i
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
