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
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <form method="POST" action="{{ route('informes.store') }}" enctype="multipart/form-data">
                        @csrf
                        @if ($reportsArray)
                        <div class="row mb-3">
                            {!! Form::label('', 'Informes subidos', ['class' => 'col-md-4 col-form-label text-md-end'])
                            !!}
                            <div class="col-md-6 scroll-studies">
                                <ul class="list-group">
                                    @foreach ($reportsArray as $directorie)
                                    @foreach ($directorie as $dir)
                                    <li class="list-group-item">
                                        {!! Form::checkbox('files[]', $dir, 'true', ['class' => 'form-check-input']) !!}
                                        {{ $dir }}</li>
                                    @endforeach
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
                                'required', 'autofocus']) !!}
                                @error('report_number')
                                <strong class="text-danger text-center mt-5">{{ 'El campo número de informe es
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
                                {!! Form::select('report_type', $report_type, '', ['class' => 'form-select', 'id' =>
                                'status', 'placeholder' => 'Seleccione el tipo de reporte']) !!}
                                @error('report_type')
                                <strong class="text-danger text-center mt-5">{{ 'Seleccione el tipo de reporte'
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
                                {!! Form::date('end_date', '', ['class' => 'form-control', 'required']) !!}
                                @error('end_date')
                                <strong class="text-danger text-center mt-5">{{ 'El campo fecha final
                                    obligatorio'
                                    }}</strong>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            {!! Form::label('reports', 'Informes', ['class' => 'col-md-4 col-form-label text-md-end'])
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
                        {!! Form::number('user_id', Auth::user()->id, ['class' => 'form-control', 'hidden', 'required'])
                        !!}
                        {!! Form::number('project_id', $project->id, ['class' => 'form-control', 'hidden', 'required'])
                        !!}
                        {!! Form::number('studio_id', $idStudio, ['class' => 'form-control', 'hidden', 'required']) !!}
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                {!! Form::submit('Crear', ['class' => 'btn btn-primary']) !!}
                                <a class="btn btn-danger" href="{{ route('studies-list', $project->id) }}">Cancelar
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
