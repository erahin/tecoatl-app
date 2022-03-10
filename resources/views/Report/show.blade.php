@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h1 class="text-center text-primary">Archivos subidos del estudio {{ $studio->name }} del Proyecto
                        {{ $project->abbreviation }}.
                    </h1>
                </div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <div class="d-flex justify-content-start flex-wrap mb-2">
                        <a class="btn btn-outline-primary"
                            href="{{ route('reports-list', ['id' => $project->id, 'idStudio' => $studio->id]) }}">Regresar
                        </a>
                    </div>
                    <h2 class="h6 text-center">Ruta:
                        {{ $project->abbreviation }}/{{ $studio->name }}/{{ $report->report_number }}° Reporte
                    </h2>
                    {{-- <h2 class="h4"></h2> --}}
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Archivo</th>
                                <th scope="col">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($files as $file)
                            <tr>
                                <td>
                                    {{ explode('/', $file)[5] }}
                                </td>
                                <td>
                                    <a target="_blank" class="btn btn-outline-primary"
                                        href="https://torvik-dev.s3.us-east-2.amazonaws.com/{{ $file }}">Abrir</a>
                                    {{-- <a class="btn btn-outline-secondary"
                                        href="{{ route('downloadFile', ['file_path' => $file]) }}">Descargar</a> --}}
                                    <a class="btn btn-outline-secondary"
                                        href="{{ route('downloadFile', ['idProject' => $project->id, 'idStudio' => $studio->id, 'idReport' => $report->id, 'nameFile' => explode('/', $file)[5]]) }}">Descargar</a>
                                    <a class="btn btn-outline-danger"
                                        href="{{ route('deleteFile', ['idProject' => $project->id,'idStudio' => $studio->id,'idReport' => $report->id,'nameFile' => explode('/', $file)[5]]) }}"
                                        onclick="return confirm( '¿Está seguro de eliminar {{ explode('/', $file)[5] }}?') ">Eliminar</a>
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
