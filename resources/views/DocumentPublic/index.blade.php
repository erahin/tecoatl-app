@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h1 class="text-center">Lista de carpetas públicas
                    </h1>
                    <div>
                        <div class="input-group d-flex justify-content-end">
                            <div class="form-outline">
                                <input type="search" id="search" class="form-control" placeholder="Buscar"
                                    onkeyup='searchTable()' />
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
                        @can('createFolderPublic')
                        <a class="btn btn-primary my-2 ancla" href="{{ route('createFolderPublic') }}" role="button"><i
                                class="fa fa-plus" aria-hidden="true"></i> Crear
                            carpeta</a>
                        @endcan
                        <a class=" btn btn-secondary my-2" href="{{ route('publico.index') }}" role="button">
                            <i class="fa fa-list" aria-hidden="true"></i> Lista completa</a>
                    </div>
                    <table class="table table-hover table-bordered" id="table">
                        <thead>
                            <tr>
                                <th scope="col">Carpeta</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($folders) != 0)
                            @foreach ($folders as $folder)
                            <tr>
                                <td>{{ explode('/', $folder)[1] }}</td>
                                <td class="d-flex justify-content-start">
                                    @can('uploadFileForm')
                                    <a title="Subir archivos"
                                        href="{{ route('uploadFileForm', ['path' => str_replace('/', '-', $folder)]) }}"
                                        class="btn btn-secondary ancla"> <i class="fa fa-upload"
                                            aria-hidden="true"></i></a>
                                    @endcan
                                    @can('publicFilesList')
                                    <a title="Lista de archivos"
                                        href="{{ route('publicFilesList', ['path' => str_replace('/', '-', $folder)]) }}"
                                        class="btn btn-primary ancla"><i class="fa fa-list-alt"
                                            aria-hidden="true"></i></a>
                                    @endcan
                                    @can('publico.destroy')
                                    <a title="Eliminar"
                                        onclick="return confirm( '¿Está seguro de eliminar {{ explode('/', $folder)[1] }}?') "
                                        href="{{ route('publico.destroy', ['path' => str_replace('/', '-', $folder)]) }}"
                                        class="btn btn-danger ancla"><i class="fa fa-trash-o"
                                            aria-hidden="true"></i></a>
                                    @endcan
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
