@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h1 class="text-center">Lista de informes de <span class="header_span">{{ $studio->name }}</span>
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
                    <div class="d-flex justify-content-start flex-wrap mb-2">
                        <a class="btn btn-outline-primary" href="{{ route('studies-list', $project->id) }}"><i
                                class="fa fa-chevron-left" aria-hidden="true"></i> Regresar
                        </a>
                    </div>
                    <div class="mb-3">
                        <h2 class="h6 text-center">Ruta: Técnico/{{ $project->regions->name }}/{{
                            $project->abbreviation
                            }}/{{ $studio->name }}
                        </h2>
                    </div>
                    <table class="table table-hover table-bordered display" id="table">
                        <thead>
                            <tr>
                                <th scope="col">Número de informe</th>
                                <th scope="col">Nombre de informe</th>
                                <th scope="col">Tipo de reporte</th>
                                <th scope="col">Fecha inicio</th>
                                <th scope="col">Fecha final</th>
                                <th scope="col" colspan="1">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($reports == null)
                            <tr>
                                <td colspan="2">No existen informes</td>
                            </tr>
                            @endif
                            @if ($reports)
                            @foreach ($reports as $report)
                            <tr>
                                <td>{{ $report->report_number }}° informe</td>
                                <td>{{ $report->name }}</td>
                                <td>{{ $report_type[$report->report_type] }}</td>
                                <td>{{ $report->start_date }}</td>
                                <td>{{ $report->end_date }}</td>
                                <td>
                                    @can('uploadFileReport')
                                    <a title="Agregar archivos"
                                        href="{{ route('uploadFormFile', ['idReport' => $report->id, 'idStudio' => $studio->id, 'idProject' => $project->id]) }}"
                                        class="btn btn-outline-primary"><i class="fa fa-upload"
                                            aria-hidden="true"></i></a>
                                    @endcan
                                    @can('show-informs')
                                    <a title="Lista de archivos"
                                        href="{{ route('show-informs', ['idProject' => $project->id, 'idStudio' => $studio->id, 'idReport' => $report->id]) }}"
                                        class="btn btn-outline-secondary"><i class="fa fa-list-alt"
                                            aria-hidden="true"></i></a>
                                    @endcan
                                    @can('report-edit')
                                    <a title="Editar informe"
                                        href="{{ route('report-edit', ['id' => $report->id, 'idStudio' => $studio->id, 'idProject' => $project->id]) }}"
                                        class="btn btn-outline-success"><i class="fa fa-pencil-square-o"
                                            aria-hidden="true"></i></a>
                                    @endcan
                                    @can('deleteReportsDirectory')
                                    <a title="Eliminar informe"
                                        href="{{ route('deleteReportsDirectory', ['idProject' => $project->id,'idStudio' => $studio->id,'idReport' => $report->id]) }}"
                                        class="btn btn-outline-danger"
                                        onclick="return confirm( '¿Está seguro de eliminar la carpeta {{ $report->report_number }} informe, tenga en cuenta que se eliminará todos los archivos que existan dentro de la misma?') "><i
                                            class="fa fa-trash-o" aria-hidden="true"></i></a>
                                    @endcan
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/table.js') }}"></script>
@endsection
