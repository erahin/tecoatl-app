@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h1 class="text-center">Lista de subcarpetas
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
                        <a class="btn btn-outline-primary"
                            href="{{ route('folderList', ['idAdministrative' => $idAdministrative]) }}"><i
                                class=" fa fa-chevron-left" aria-hidden="true"></i> Regresar
                        </a>
                    </div>
                    <table class="table table-hover table-bordered" id="table">
                        <thead>
                            <tr>
                                <th scope="col">Carpeta</th>
                                <th scope="col" colspan="2">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($folderArray) != 0)
                            @foreach ($folderArray as $directorie)
                            <tr>
                                <td>{{ explode('/', $directorie)[3] }}</td>
                                <td class="d-flex justify-content-start">
                                    <a title="Subir archivos"
                                        href="{{ route('showFormUploadFileSubFolder', ['idAdministrative' => $idAdministrative,
                                        'folder' => explode('/', $directorie)[2], 'subfolder' => explode('/', $directorie)[3]] ) }}"
                                        class="btn btn-secondary ancla"> <i class="fa fa-upload"
                                            aria-hidden="true"></i></a>
                                    <a title="Lista de archivos"
                                        href="{{ route('subFolderFileList', ['idAdministrative' => $idAdministrative, 'folder' => explode('/', $directorie)[2], 'subfolder' => explode('/', $directorie)[3]]) }}"
                                        class="btn btn-primary ancla"><i class="fa fa-list-alt"
                                            aria-hidden="true"></i></a>
                                    <a title="Eliminar carpeta"
                                        href="{{ route('deleteFolder', ['idAdministrative' => $idAdministrative, 'folder' => explode('/', $directorie)[2]]) }}"
                                        class="btn btn-outline-danger"
                                        onclick="return confirm( '¿Está seguro de eliminar la carpeta {{ explode('/', $directorie)[2] }}, tenga en cuenta que se eliminará todos los archivos que existan dentro de la misma?') "><i
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
