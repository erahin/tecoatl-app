@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h1 class="text-center">Archivos subidos del estudio <span class="header_span">{{ $studio->name
                            }}</span> del proyecto
                        {{ $project->abbreviation }}
                    </h1>
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
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <div class="d-flex justify-content-start flex-wrap mb-2">
                        <a class="btn btn-outline-primary"
                            href="{{ route('reports-list', ['id' => $project->id, 'idStudio' => $studio->id]) }}"><i
                                class="fa fa-chevron-left" aria-hidden="true"></i> Regresar
                        </a>
                    </div>
                    <div class="mb-3">
                        <h2 class="h6 text-center">Ruta:
                            Técnico/{{ $project->regions->name }}/{{ $project->abbreviation }}/{{ $studio->name }}/{{
                            $report->report_number }}°
                            Informe {{
                            $report_type[$report->report_type] }} - {{ $report->name }}
                        </h2>
                    </div>
                    <div class="overflow-y">
                        <table class="table table-hover table-bordered" id="table">
                            <thead>
                                <tr>
                                    <th scope="col">Archivo</th>
                                    <th scope="col">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($files) == 0)
                                <tr>
                                    <td colspan="2">
                                        No existen archivos
                                    </td>
                                </tr>
                                @else
                                @foreach ($files as $file)
                                <tr>
                                    <td>
                                        {{ explode('/', $file)[5] }}
                                    </td>
                                    <td>
                                        <a title="Abrir" target="_blank" class="btn btn-outline-primary"
                                            href="https://torvik-dev.s3.us-east-2.amazonaws.com/{{ $file }}"><i
                                                class="fa fa-external-link" aria-hidden="true"></i></a>
                                        @can('downloadFile')
                                        <a title="Descargar" class="btn btn-outline-secondary"
                                            href="{{ route('downloadFile', ['idProject' => $project->id, 'idStudio' => $studio->id, 'idReport' => $report->id, 'nameFile' => explode('/', $file)[5]]) }}"><i
                                                class="fa fa-download" aria-hidden="true"></i></a>
                                        @endcan
                                        @can('deleteFile')
                                        <a title="Eliminar" class="btn btn-outline-danger"
                                            href="{{ route('deleteFile', ['idProject' => $project->id,'idStudio' => $studio->id,'idReport' => $report->id,'nameFile' => explode('/', $file)[5]]) }}"
                                            onclick="return confirm( '¿Está seguro de eliminar {{ explode('/', $file)[5] }}?') "><i
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
</div>
@endsection
