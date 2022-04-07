@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h1 class="text-center">Crear proyecto
                    </h1>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('proyectos.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            {!! Form::label('place', 'Nombre del proyecto', ['class' => 'col-md-4 col-form-label
                            text-md-end']) !!}
                            <div class="col-md-6">
                                {!! Form::text('place', '', ['class' => 'form-control', 'autofocus', 'required', 'id' =>
                                'place','onkeyup' => 'firstLetterToCapitalize(place);']) !!}
                                @error('place')
                                <strong class="text-danger text-center mt-5">{{ 'El campo lugar es obligatorio'
                                    }}</strong>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            {!! Form::label('abbreviation', 'Abreviación', [
                            'class' => 'col-md-4 col-form-label
                            text-md-end',
                            ]) !!}
                            <div class="col-md-6">
                                {!! Form::text('abbreviation', '', ['class' => 'form-control', 'required', 'id' =>
                                'abbreviation','onkeyup' => 'javascript:this.value=this.value.toUpperCase();']) !!}
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
                                {!! Form::select('status', $status, '', ['class' => 'form-select', 'id' =>
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
                                {!! Form::select('region_id', $regions, $id, ['class' => 'form-select', 'id' =>
                                'region_id', 'placeholder' => 'Seleccione Región']) !!}
                                @error('region_id')
                                <strong class="text-danger text-center mt-5">{{ 'El campo región es obligatorio'
                                    }}</strong>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            {!! Form::label('studie_id', 'Estudios', ['class' => 'col-md-4 col-form-label text-md-end'])
                            !!}
                            <div class="col-md-6">
                                <div class="form-check scroll-studies">
                                    @foreach ($studies as $study)
                                    <label class="form-check-label inline_label">
                                        {!! Form::checkbox('studie_id[]', $study->id, null, ['class' =>
                                        'form-check-input']) !!}
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
                        {!! Form::number('user_id', Auth::user()->id, ['class' => 'form-control', 'hidden', 'required'])
                        !!}
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                {{ Form::button('<i class="fa fa-plus" aria-hidden="true"></i> Crear', ['type' =>
                                'submit', 'class' =>
                                'btn btn-primary', 'id' => 'btn-submit'] ) }}
                                <a class="btn btn-danger" href="{{ route('projectByRegion', ['id' => $id]) }}"><i
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
