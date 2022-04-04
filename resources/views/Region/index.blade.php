@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h1 class="text-center">Lista de Regiones.
                    </h1>
                    <div>
                        <form action="{{ route('regiones.index') }}" class="input-group d-flex justify-content-end">
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
                        <a class="btn btn-primary my-2 ancla" href="{{ route('regiones.create') }}" role="button"><i
                                class="fa fa-plus" aria-hidden="true"></i> Crear
                            Región</a>
                        <a class=" btn btn-secondary my-2" href="{{ route('regiones.index') }}" role="button">
                            <i class="fa fa-list" aria-hidden="true"></i> Lista completa</a>
                    </div>
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Nombre de región</th>
                                <th scope="col" colspan="2">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($regions) != 0)
                            @foreach ($regions as $region)
                            <tr>
                                <td>{{ $region->name }}</td>
                                <td class="d-flex justify-content-start">
                                    <a href="{{ route('regiones.edit', $region->id) }}" class="btn btn-success ancla"><i
                                            class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar</a>
                                    <form action="{{ route('regiones.destroy', $region->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger"
                                            onclick="return confirm( '¿Está seguro de eliminar {{ $region->name }}?') "><i
                                                class="fa fa-trash-o" aria-hidden="true"></i>
                                            Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="4">No existen regiones.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                    {{ $regions->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    localStorage.setItem("regions", "{{ $regionArray }}");
        localStorage.setItem("namesRegions", "{{ $regionNameArray }}");
</script>
@endsection
