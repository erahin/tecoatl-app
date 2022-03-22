@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h1 class="text-center text-primary">Lista de Proyectos de la región {{ $region->name }}.
                    </h1>
                    <div>
                        <form action="{{ route('searchProjectByRegion', ['id' => $id, 'idUser' => Auth::user()->id]) }}"
                            class="input-group d-flex justify-content-end">
                            <div class="form-outline">
                                <input type="text" name="search" class="form-control" placeholder="Buscar" required />
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-search"></i>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <div class="d-flex justify-content-start flex-wrap">
                        @can('proyectos.create')
                        <a class=" btn btn-primary my-2 ancla"
                            href="{{ route('createProjectByRegion', ['id' => $id, 'idUser' => Auth::user()->id]) }}"
                            role="button">
                            Crear
                            Proyectos</a>
                        @endcan
                        <a class=" btn btn-secondary my-2"
                            href="{{ route('projectByRegion', ['id' => $id, 'idUser' => Auth::user()->id]) }}"
                            role="button">
                            Lista completa</a>
                        {{-- <a class=" btn btn-primary my-2" href="{{ route('proyectos.create') }}" role="button">
                            Crear
                            Proyectos</a> <a class=" btn btn-primary my-2" href="{{ route('proyectos.create') }}"
                            role="button">
                            Crear
                            Proyectos</a>
                        <a class=" btn btn-primary my-2" href="{{ route('proyectos.create') }}" role="button">
                            Crear
                            Proyectos</a> --}}
                    </div>
                    <table class="table table-hover table-bordered" id="table">
                        <thead>
                            <tr>
                                <th scope="col">Nombre del proyecto</th>
                                <th scope="col">Abreviación</th>
                                <th scope="col">Estatus</th>
                                <th scope="col" colspan="2">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($projects) != 0)
                            @foreach ($projects as $project)
                            <tr>
                                <td>{{ $project->place }}</td>
                                <td>{{ $project->abbreviation }}</td>
                                <td>{{ $status[$project->status] }}</td>
                                <td class="d-flex justify-content-start">
                                    @can('studies-list')
                                    <a href="{{ route('studies-list', $project->id) }}" class="btn btn-primary ancla">
                                        Reportes</a>
                                    @endcan
                                    @can('proyectos.edit')
                                    <a href="{{ route('proyectos.edit', $project->id) }}"
                                        class="btn btn-success ancla">Editar</a>
                                    @endcan
                                    @can('proyectos.destroy')
                                    <form
                                        action="{{ route('destroyProjectByRegion',[ 'id' => $project->id, 'idUser' => Auth::user()->id]) }}"
                                        method="post">
                                        @csrf
                                        @method('delete')
                                        <input type="submit" value="Eliminar" class="btn btn-danger"
                                            onclick="return confirm( '¿Está seguro de eliminar {{ $project->abbreviation }}?') ">
                                    </form>
                                    @endcan
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="4">No existen proyectos.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                    {{ $projects->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
