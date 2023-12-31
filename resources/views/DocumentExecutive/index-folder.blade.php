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
                        <a class="btn btn-outline-primary" href="{{ route('directivo.index') }}"><i
                                class=" fa fa-chevron-left" aria-hidden="true"></i> Regresar
                        </a>
                    </div>
                    <h2 class="h6 text-center">Ruta: {{ $path }}</h2>
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
                                    <a title="Subir archivos"
                                        href="{{ route('directivo.createUpload', ['path' => str_replace('/', '-', $directorie)]) }}"
                                        class="btn btn-success ancla"> <i class="fa fa-upload"
                                            aria-hidden="true"></i></a>
                                    <a title="Lista de archivos"
                                        href="{{ route('directivo.fileList', ['path' => str_replace('/', '-', $directorie)]) }}"
                                        class="btn btn-primary ancla"><i class="fa fa-list-alt"
                                            aria-hidden="true"></i></a>
                                    <a title="Eliminar carpeta"
                                        href="{{ route('directivo.destroy', ['path' => str_replace('/', '-', $directorie)]) }}"
                                        class="btn btn-outline-danger"
                                        onclick="return confirm( '¿Está seguro de eliminar la carpeta {{ explode('/', $directorie)[$index+1] }}, tenga en cuenta que se eliminará todos los archivos que existan dentro de la misma?') "><i
                                            class="fa fa-trash-o" aria-hidden="true"></i></a>
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
