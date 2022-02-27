@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h1 class="text-center text-primary">Lista de Proyectos.
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
                        <div class="d-flex justify-content-start flex-wrap">
                            <a class=" btn btn-primary my-2" href="{{ route('proyectos.create') }}" role="button">
                                Crear
                                Proyectos</a>
                            {{-- <a class=" btn btn-primary my-2" href="{{ route('proyectos.create') }}" role="button">
                                Crear
                                Proyectos</a> <a class=" btn btn-primary my-2" href="{{ route('proyectos.create') }}"
                                role="button">
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
                                    <th scope="col">Lugar</th>
                                    <th scope="col">Abreviación</th>
                                    <th scope="col">Región</th>
                                    <th scope="col" colspan="2">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($projects as $project)
                                    <tr>
                                        <td>{{ $project->place }}</td>
                                        <td>{{ $project->abbreviation }}</td>
                                        <td>{{ $project->regions->name }}</td>
                                        <td class="d-flex justify-content-around"><a
                                                href="{{ route('proyectos.show', $project->id) }}"
                                                class="btn btn-secondary">Detalle</a>
                                            <a href="{{ route('proyectos.edit', $project->id) }}"
                                                class="btn btn-success">Editar</a>
                                            <form action="{{ route('proyectos.destroy', $project->id) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <input type="submit" value="Eliminar" class="btn btn-danger"
                                                    onclick="return confirm( '¿Está seguro de eliminar {{ $project->abbreviation }}?') ">
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $projects->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
