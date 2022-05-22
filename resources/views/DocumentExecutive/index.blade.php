@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h1 class="text-center">Lista de carpetas directivas
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
                        <a class="btn btn-primary my-2 ancla" href="{{ route('directivo.create') }}" role="button"><i
                                class="fa fa-plus" aria-hidden="true"></i> Crear
                            carpeta</a>
                        <a class=" btn btn-secondary my-2" href="{{ route('directivo.index') }}" role="button">
                            <i class="fa fa-list" aria-hidden="true"></i> Lista completa</a>
                    </div>
                    <table class="table table-hover table-bordered" id="table">
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
                                    <a title="Nueva carpeta"
                                        href="{{ route('directivo.create-subfolder', ['path' => str_replace('/', '-', $folder)]) }}"
                                        class="btn btn-secondary ancla"> <i class="fa fa-folder-open"
                                            aria-hidden="true"></i></a>
                                    <a title="Lista de carpetas"
                                        href="{{ route('directivo.folder-list', ['path' => str_replace('/', '-', $folder)]) }}"
                                        class="btn btn-primary ancla"><i class="fa fa-archive"
                                            aria-hidden="true"></i></a>
                                    <a title="Subir archivos"
                                        href="{{ route('directivo.createUpload', ['path' => str_replace('/', '-', $folder)]) }}"
                                        class="btn btn-success ancla"> <i class="fa fa-upload"
                                            aria-hidden="true"></i></a>
                                    <a title="Lista de archivos"
                                        href="{{ route('directivo.fileList', ['path' => str_replace('/', '-', $folder)]) }}"
                                        class="btn btn-outline-primary ancla"><i class="fa fa-list-alt"
                                            aria-hidden="true"></i></a>
                                    <a title="Eliminar"
                                        onclick="return confirm( '¿Está seguro de eliminar {{ explode('/', $folder)[1] }}?') "
                                        href="{{ route('directivo.destroy', ['path' => str_replace('/', '-', $folder)]) }}"
                                        class="btn btn-danger ancla"><i class="fa fa-trash-o"
                                            aria-hidden="true"></i></a>
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
