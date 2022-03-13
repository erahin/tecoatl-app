@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h1 class="text-center text-primary">Editar Proyecto.
                    </h1>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('proyectos.update', $project->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            {!! Form::label('place', 'Lugar', ['class' => 'col-md-4 col-form-label text-md-end']) !!}
                            <div class="col-md-6">
                                {!! Form::text('place', $project->place, ['class' => 'form-control', 'autofocus',
                                'required', 'id' => 'place']) !!}
                                @error('place')
                                <strong class="text-danger text-center mt-5">{{ 'El campo lugar es obligatorio'
                                    }}</strong>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            {!! Form::label('abbreviation', 'Abreviación', ['class' => 'col-md-4 col-form-label
                            text-md-end',]) !!}
                            <div class="col-md-6">
                                {!! Form::text('abbreviation', $project->abbreviation, ['class' => 'form-control',
                                'required', 'id' => 'abbreviation']) !!}
                                @error('abbreviation')
                                <strong class="text-danger text-center mt-5">{{ 'El campo abreviación es obligatorio'
                                    }}</strong>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            {!! Form::label('status', 'Estatus del proyecto', ['class' => 'col-md-4 col-form-label
                            text-md-end'])
                            !!}
                            <div class="col-md-6">
                                {!! Form::select('status', $status, $project->status, ['class' => 'form-select', 'id' =>
                                'status', 'placeholder' => 'Seleccione el estatus']) !!}
                                @error('status')
                                <strong class="text-danger text-center mt-5">{{ 'El campo estatus es obligatorio'
                                    }}</strong>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            {!! Form::label('region_id', 'Regíon', ['class' => 'col-md-4 col-form-label text-md-end'])
                            !!}
                            <div class="col-md-6">
                                {!! Form::select('region_id', $regions, $project->region_id, ['class' => 'form-select',
                                'id' => 'region_id', 'placeholder' => 'Seleccione Región']) !!}
                                @error('region_id')
                                <strong class="text-danger text-center mt-5">{{ 'El campo región es obligatorio'
                                    }}</strong>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            {!! Form::label('studie_id', 'Estudios', ['class' => 'col-md-4 col-form-label text-md-end'])
                            !!}
                            <div class="col-md-6 scroll-studies">
                                <div class="form-check form-check-inline ml-5">
                                    @foreach ($studies as $study)
                                    <label class="form-check-label inline_label">
                                        {!! Form::checkbox('studie_id[]', $study->id, null, ['class' =>
                                        'form-check-input', 'id' => $study->id]) !!}
                                        {{ $study->name }}
                                    </label>
                                    @endforeach
                                </div>
                                @error('studie_id')
                                <strong class="text-danger text-center mt-5">{{ 'Seleccione al menos un estudio'
                                    }}</strong>
                                @enderror
                            </div>
                        </div>
                        @foreach ($project->studys as $registre)
                        @foreach ($studies as $study)
                        @if ($study->id == $registre->id)
                        <script>
                            checkActive({{ $study->id }});

                                            function checkActive(idStudy) {
                                                let id = idStudy;
                                                let checkStudy = document.getElementById(
                                                    id
                                                );
                                                checkStudy.setAttribute("checked", "");
                                            }
                        </script>
                        @endif
                        @endforeach
                        @endforeach
                        {!! Form::number('user_id', Auth::user()->id, ['class' => 'form-control', 'hidden', 'required'])
                        !!}
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                {!! Form::submit('Editar', ['class' => 'btn btn-primary']) !!}
                                <a class="btn btn-danger" href="{{ route('proyectos.index') }}">Cancelar
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
