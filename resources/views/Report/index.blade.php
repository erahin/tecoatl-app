@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h1 class="text-center text-primary">Lista de Estudios de {{ $project->abbreviation }}.
                        </h1>
                        <div>
                            <div class="input-group d-flex justify-content-end">
                                <div class="form-outline">
                                    <input type="search" id="form1" class="form-control" placeholder="Buscar" />
                                </div>
                                <button type="button" class="btn btn-primary">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="d-flex justify-content-start flex-wrap mb-2">
                            <a class="btn btn-outline-primary" href="{{ route('proyectos.index') }}">Regresar
                            </a>
                        </div>
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Nombre del estudio</th>
                                    <th scope="col" colspan="1">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($project->studys as $registre)
                                    <tr>
                                        <td>{{ $registre->name }}</td>
                                        <td><a href="{{ route('upload-reports', ['id' => $project->id, 'idStudio' => $registre->id]) }}"
                                                class="btn btn-outline-primary">Agregar
                                                informes</a>
                                            <a href="{{ route('reports-list', ['id' => $project->id, 'idStudio' => $registre->id]) }}"
                                                class="btn btn-outline-success">Lista de informes
                                            </a>
                                            <a href="{{ route('deleteStudioDirectory', ['idProject' => $project->id, 'idStudio' => $registre->id]) }}"
                                                class="btn btn-outline-danger"
                                                onclick="return confirm( '¿Está seguro de eliminar la carpeta {{ $registre->name }}, tenga en cuenta que se eliminará todos los archivos que existan dentro de la misma?') ">Eliminar
                                                carpeta</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
