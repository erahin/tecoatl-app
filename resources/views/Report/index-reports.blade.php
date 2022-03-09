@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h1 class="text-center text-primary">Lista de Informes de {{ $studio->name }}.
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
                            <a class="btn btn-outline-primary" href="{{ route('studies-list', $project->id) }}">Regresar
                            </a>
                        </div>
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Número de informe</th>
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
                                            <td>{{ $report->report_type }}</td>
                                            <td>{{ $report->start_date }}</td>
                                            <td>{{ $report->end_date }}</td>
                                            <td>
                                                <a href="{{ route('show-informs', ['idProject' => $project->id, 'idStudio' => $studio->id, 'idReport' => $report->id]) }}"
                                                    class="btn btn-outline-secondary">Lista de archivos</a>
                                                <a href="{{ route('deleteReportsDirectory', ['idProject' => $project->id,'idStudio' => $studio->id,'idReport' => $report->id]) }}"
                                                    class="btn btn-outline-danger"
                                                    onclick="return confirm( '¿Está seguro de eliminar la carpeta {{ $report->report_number }} informe, tenga en cuenta que se eliminará todos los archivos que existan dentro de la misma?') ">Eliminar
                                                    carpeta</a>
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
@endsection
