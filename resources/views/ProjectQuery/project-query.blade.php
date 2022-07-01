@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h1 class="text-center">Lista de proyectos creados por cada usuario
                    </h1>
                </div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <table class="table table-hover table-bordered" id="table">
                        <thead>
                            <tr>
                                <th scope="col">Usuario</th>
                                <th scope="col">Nombre del proyecto</th>
                                <th scope="col">Abreviación</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($projects) != 0)
                            @foreach ($projects as $project)
                            <tr>
                                <td>{{ $project->user }}</td>
                                <td>{{ $project->place }}</td>
                                <td>{{ $project->abbreviation }}</td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="4">No existen proyectos</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
