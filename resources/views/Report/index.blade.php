@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h1 class="text-center">Lista de estudios de {{ $project->abbreviation }}
                    </h1>
                    <div>
                        <div class="input-group d-flex justify-content-end">
                            <div class="form-outline">
                                <input type="search" id="search" class="form-control" placeholder="Buscar"
                                    onkeyup='searchTable()' />
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
                    @can('proyectos.index')
                    <div class="d-flex justify-content-start flex-wrap mb-2">
                        <a class="btn btn-outline-primary"
                            href="{{ route('projectByRegion', ['id' => $region_id]) }}"><i class="fa fa-chevron-left"
                                aria-hidden="true"></i> Regresar
                        </a>
                    </div>
                    @endcan
                    <table class="table table-hover table-bordered" id="table">
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
                                <td>
                                    @can('upload-reports')
                                    <a title="Agregar
                                        informes"
                                        href="{{ route('upload-reports', ['id' => $project->id, 'idStudio' => $registre->id]) }}"
                                        class="btn btn-outline-primary"><i class="fa fa-file-pdf-o"
                                            aria-hidden="true"></i></a>
                                    @endcan
                                    @can('reports-list')
                                    <a title="Lista de informes"
                                        href="{{ route('reports-list', ['id' => $project->id, 'idStudio' => $registre->id]) }}"
                                        class="btn btn-outline-success"><i class="fa fa-list-alt"
                                            aria-hidden="true"></i>
                                    </a>
                                    @endcan
                                    @can('deleteStudioDirectory')
                                    <a title="Eliminar
                                        carpeta"
                                        href="{{ route('deleteStudioDirectory', ['idProject' => $project->id, 'idStudio' => $registre->id]) }}"
                                        class="btn btn-outline-danger"
                                        onclick="return confirm( '¿Está seguro de eliminar la carpeta {{ $registre->name }}, tenga en cuenta que se eliminará todos los archivos que existan dentro de la misma?') "><i
                                            class="fa fa-trash-o" aria-hidden="true"></i></a>
                                    @endcan
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
<script src="{{ asset('js/table.js') }}" defer></script>
@endsection
