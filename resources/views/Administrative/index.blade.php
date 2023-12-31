@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h1 class="text-center">Lista de departamentos administrativos
                    </h1>
                    <div>
                        <form action="{{ route('administrativos.index') }}"
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
                        @can('administrativos.create')
                        <a class="btn btn-primary my-2 ancla" href="{{ route('administrativos.create') }}"
                            role="button"><i class="fa fa-plus" aria-hidden="true"></i> Crear departamento</a>
                        @endcan
                        <a class=" btn btn-secondary my-2" href="{{ route('administrativos.index') }}" role="button">
                            <i class="fa fa-list" aria-hidden="true"></i> Lista completa</a>
                    </div>
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Nombre del departamento</th>
                                <th scope="col" colspan="2">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($administratives) != 0)
                            @foreach ($administratives as $administrative)
                            <tr>
                                <td>{{ $administrative->name }}</td>
                                <td class="d-flex justify-content-start">
                                    @can('createFolder')
                                    @if ($administrative->id != 1)
                                    <a title="Nueva carpeta"
                                        href="{{ route('createFolder', ['idAdministrative' => $administrative->id]) }}"
                                        class="btn btn-secondary ancla"> <i class="fa fa-folder-open"
                                            aria-hidden="true"></i></a>
                                    @endif
                                    @endcan
                                    @can('folderList')
                                    <a title="Lista de carpetas"
                                        href="{{ route('folderList', ['idAdministrative' => $administrative->id]) }}"
                                        class="btn btn-primary ancla"><i class="fa fa-archive"
                                            aria-hidden="true"></i></a>
                                    @endcan
                                    @can('administrativos.edit')
                                    <a title="Editar" href="{{ route('administrativos.edit', $administrative->id) }}"
                                        class="btn btn-success ancla"><i class="fa fa-pencil-square-o"
                                            aria-hidden="true"></i></a>
                                    @endcan
                                    @can('administrativos.destroy')
                                    <form action="{{ route('administrativos.destroy', $administrative->id) }}"
                                        method="post">
                                        @csrf
                                        @method('delete')
                                        <button title="Eliminar" type="submit" class="btn btn-danger"
                                            onclick="return confirm( '¿Está seguro de eliminar {{ $administrative->name }}?') "><i
                                                class="fa fa-trash-o" aria-hidden="true"></i></button>
                                    </form>
                                    @endcan
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="4">No existen departamentos.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                    {{ $administratives->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
