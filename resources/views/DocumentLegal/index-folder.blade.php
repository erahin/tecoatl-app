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
                    <div class="d-flex justify-content-start flex-wrap mb-2">
                        @if (count($array) == 2)
                        <a class="btn btn-outline-primary" href="{{ route('legal.index') }}"><i
                                class=" fa fa-chevron-left" aria-hidden="true"></i> Regresar
                        </a>
                        @else
                        <a class="btn btn-outline-primary ancla"
                            href="{{ route('legal.folder-list', ['path' => str_replace('/', '-', $previousPath)]) }}"><i
                                class=" fa fa-chevron-left" aria-hidden="true"></i> Regresar
                        </a>
                        <a class="btn btn-outline-primary"
                            href="{{ route('legal.folder-list', ['path' => str_replace('/', '-', $homepath)]) }}"><i
                                class="fa fa-home" aria-hidden="true"></i> Directorio principal
                        </a>
                        @endif
                    </div>
                    <h2 class="h6 text-center">Ruta: <span class="text-capitalize">{{ $path }}/</span></h2>
                    <table class="table table-hover table-bordered" id="table">
                        <thead>
                            <tr>
                                <th scope="col">Carpeta</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($directories) != 0)
                            @foreach ($directories as $directorie)
                            <tr>
                                <td>{{ explode('/', $directorie)[$index+1] }}</td>
                                <td class="d-flex justify-content-start">
                                    @can('legal.create-subfolder')
                                    <a title="Nueva carpeta"
                                        href="{{ route('legal.create-subfolder', ['path' => str_replace('/', '-', $directorie)]) }}"
                                        class="btn btn-secondary ancla"> <i class="fa fa-folder-open"
                                            aria-hidden="true"></i></a>
                                    @endcan
                                    @can('legal.folder-list')
                                    <a title="Lista de carpetas"
                                        href="{{ route('legal.folder-list', ['path' => str_replace('/', '-', $directorie)]) }}"
                                        class="btn btn-primary ancla"><i class="fa fa-archive"
                                            aria-hidden="true"></i></a>
                                    @endcan
                                    @can('legal.createUpload')
                                    <a title="Subir archivos"
                                        href="{{ route('legal.createUpload', ['path' => str_replace('/', '-', $directorie)]) }}"
                                        class="btn btn-success ancla"> <i class="fa fa-upload"
                                            aria-hidden="true"></i></a>
                                    @endcan
                                    @can('legal.fileList')
                                    <a title="Lista de archivos"
                                        href="{{ route('legal.fileList', ['path' => str_replace('/', '-', $directorie)]) }}"
                                        class="btn btn-outline-primary ancla"><i class="fa fa-list-alt"
                                            aria-hidden="true"></i></a>
                                    @endcan
                                    @can('legal.destroy-folder')
                                    <a title="Eliminar carpeta"
                                        href="{{ route('legal.destroy-subfolder', ['path' => str_replace('/', '-', $directorie)]) }}"
                                        class="btn btn-outline-danger"
                                        onclick="return confirm( '¿Está seguro de eliminar la carpeta {{ explode('/', $directorie)[$index+1] }}, tenga en cuenta que se eliminará todos los archivos que existan dentro de la misma?') "><i
                                            class="fa fa-trash-o" aria-hidden="true"></i></a>
                                    @endcan
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="4">No existen directorios.</td>
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
