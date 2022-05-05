@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h1 class="text-center">Lista de carpetas
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
                        {{-- @can('administrativos.create') --}}
                        <a class="btn btn-primary my-2 ancla" href="{{ route('create') }}" role="button"><i
                                class="fa fa-plus" aria-hidden="true"></i> Crear
                            carpeta</a>
                        {{-- @endcan --}}
                        <a class=" btn btn-secondary my-2" href="{{ route('administrativos.index') }}" role="button">
                            <i class="fa fa-list" aria-hidden="true"></i> Lista completa</a>
                    </div>
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Carpeta</th>
                                <th scope="col" colspan="2">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($folders) != 0)
                            @foreach ($folders as $folder)
                            <tr>
                                <td>{{ explode('/', $folder)[1] }}</td>
                                <td class="d-flex justify-content-start">
                                    {{-- @can('createFolder') --}}
                                    {{-- <a title="Nueva carpeta"
                                        href="{{ route('publico.create', ['path' => str_replace('/', '-', $folder)]) }}"
                                        class="btn btn-secondary ancla"> <i class="fa fa-folder-open"
                                            aria-hidden="true"></i></a> --}}
                                    <a title="Subir archivos"
                                        href="{{ route('uploadFileForm', ['path' => str_replace('/', '-', $folder)]) }}"
                                        class="btn btn-secondary ancla"> <i class="fa fa-upload"
                                            aria-hidden="true"></i></a>

                                    <a title="Lista de archivos"
                                        href="{{ route('publicFilesList', ['path' => str_replace('/', '-', $folder)]) }}"
                                        class="btn btn-primary ancla"><i class="fa fa-list-alt"
                                            aria-hidden="true"></i></a>
                                    {{-- @endcan --}}
                                    {{-- @can('folderList')
                                    <a title="Lista de carpetas"
                                        href="{{ route('folderList', ['idfolder' => $folder->id]) }}"
                                        class="btn btn-primary ancla"><i class="fa fa-archive"
                                            aria-hidden="true"></i></a>
                                    @endcan
                                    @can('administrativos.edit')
                                    <a title="Editar" href="{{ route('administrativos.edit', $folder->id) }}"
                                        class="btn btn-success ancla"><i class="fa fa-pencil-square-o"
                                            aria-hidden="true"></i></a>
                                    @endcan --}}
                                    {{-- @can('administrativos.destroy') --}}
                                    <a title="Eliminar"
                                        onclick="return confirm( '¿Está seguro de eliminar {{ explode('/', $folder)[1] }}?') "
                                        href="{{ route('publico.destroy', ['path' => str_replace('/', '-', $folder)]) }}"
                                        class="btn btn-danger ancla"><i class="fa fa-trash-o"
                                            aria-hidden="true"></i></a>
                                    {{-- @endcan --}}
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="4">No existen carpetas.</td>
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
