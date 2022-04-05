@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h1 class="text-center">Proyectos por zona
                    </h1>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('showRegionForm') }}">
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
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                {{ Form::button('<i class="fa fa-search" aria-hidden="true"></i> Consultar', ['type' =>
                                'submit', 'class' =>
                                'btn btn-primary'] ) }}
                                <a class="btn btn-danger" href="{{ route('home') }}"><i class="fa fa-ban"
                                        aria-hidden="true"></i> Cancelar
                                </a>
                            </div>
                        </div>
                    </form>
                    @if ($projects)
                    <table class="table table-hover table-bordered mt-4" id="example">
                        <thead>
                            <tr>
                                <th scope="col">Lugar</th>
                                <th scope="col">Abreviación</th>
                                <th scope="col">Estatus</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($projects as $project)
                            <tr>
                                <td>{{ $project->place }}</td>
                                <td>{{ $project->abbreviation }}</td>
                                <td>{{ $status[$project->status] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $projects->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
