@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h1 class="text-center">Lista de informes creados por cada usuario
                    </h1>
                </div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <table class="table table-hover table-bordered display" id="table">
                        <thead>
                            <tr>
                                <th scope="col">Usuario</th>
                                <th scope="col">Número de informe</th>
                                <th scope="col">Nombre del informe</th>
                                <th scope="col">Tipo de reporte</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($reportArray == null)
                            <tr>
                                <td colspan="2">No existen informes creados</td>
                            </tr>
                            @endif
                            @if ($reportArray)
                            @foreach ($reportArray as $report)
                            <tr>
                                <td>{{ $report->user }}</td>
                                <td>{{ $report->report_number }}° informe</td>
                                <td>{{ $report->name }}</td>
                                <td>{{ $report_type[$report->report_type] }}</td>
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
