@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h1 class="text-center text-primary">Lista de Estudios.
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
                        <a class="btn btn-primary my-2" href="{{ route('estudios.create') }}" role="button">Crear
                            Estudio</a>
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Estudio</th>
                                    <th scope="col" colspan="2">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($studies as $study)
                                    <tr>
                                        <td>{{ $study->name }}</td>
                                        <td><a href="{{ route('estudios.edit', $study->id) }}"
                                                class="btn btn-success">Editar</a>
                                        </td>
                                        <td>
                                            <form action="{{ route('estudios.destroy', $study->id) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <input type="submit" value="Eliminar" class="btn btn-danger"
                                                    onclick="return confirm( '¿Está seguro de eliminar {{ $study->name }}?') ">
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $studies->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
