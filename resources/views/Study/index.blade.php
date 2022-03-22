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
                        <form action="{{ route('estudios.index') }}" class="input-group d-flex justify-content-end">
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
                        <a class="btn btn-primary my-2 ancla" href="{{ route('estudios.create') }}" role="button"><i
                                class="fa fa-plus" aria-hidden="true"></i> Crear
                            Estudio</a>
                        <a class=" btn btn-secondary my-2" href="{{ route('regiones.index') }}" role="button">
                            <i class="fa fa-list" aria-hidden="true"></i> Lista completa</a>
                    </div>
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Estudio</th>
                                <th scope="col" colspan="2">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($studies) != 0)
                            @foreach ($studies as $study)
                            <tr>
                                <td>{{ $study->name }}</td>
                                <td class="d-flex justify-content-start"><a
                                        href="{{ route('estudios.edit', $study->id) }}"
                                        class="btn btn-success ancla">Editar</a>
                                    <form action="{{ route('estudios.destroy', $study->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <input type="submit" value="Eliminar" class="btn btn-danger"
                                            onclick="return confirm( '¿Está seguro de eliminar {{ $study->name }}?') ">
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="4">No existen estudios.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                    {{ $studies->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
