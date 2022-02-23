@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h1 class="text-center text-primary">Lista de Regiones.
                        </h1>
                    </div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <a class="btn btn-primary my-2" href="{{ route('regiones.create') }}" role="button">Crear
                            Región</a>
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Nombre de región</th>
                                    <th scope="col" colspan="2">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($regions as $region)
                                    <tr>
                                        <td>{{ $region->name }}</td>
                                        <td><a href="{{ route('regiones.edit', $region->id) }}"
                                                class="btn btn-success">Editar</a></td>
                                        <td>
                                            <form action="{{ route('regiones.destroy', $region->id) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <input type="submit" value="Eliminar" class="btn btn-danger"
                                                onclick="return confirm( '¿Está seguro de eliminar {{ $region->name }}?') ">
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $regions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
