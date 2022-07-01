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
                        <a class="btn btn-outline-primary" href="{{ route('administrativos.index') }}"><i
                                class=" fa fa-chevron-left" aria-hidden="true"></i> Regresar
                        </a>
                    </div>
                    <h2 class="h6 text-center">Ruta: Administrativo/{{ $administrative->name }}/</h2>
                    <table class="table table-hover table-bordered" id="table">
                        <thead>
                            <tr>
                                <th scope="col">Carpeta</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($folderArray) != 0 || count($projectArray) != 0)
                            @if (count($projectArray) != 0 && $idAdministrative==1)
                            @for($i = 0; $i < count($projectArray); $i++) <tr>
                                <td>{{ $projectArray[$i]->place }}</td>
                                <td class="d-flex justify-content-start">
                                    @can('showFormUploadFile')
                                    <a title="Subir archivos"
                                        href="{{ route('showFormUploadFile', ['idAdministrative' => $idAdministrative, 'folder' => $projectArray[$i]->id]) }}"
                                        class="btn btn-secondary ancla"> <i class="fa fa-upload"
                                            aria-hidden="true"></i></a>
                                    @endcan
                                    @can('fileList')
                                    <a title="Lista de archivos"
                                        href="{{ route('fileList', ['idAdministrative' => $idAdministrative, 'folder' => $projectArray[$i]->id]) }}"
                                        class="btn btn-primary ancla"><i class="fa fa-list-alt"
                                            aria-hidden="true"></i></a>
                                    @endcan
                                    @can('createFolder')
                                    <a title="Nueva carpeta"
                                        href="{{ route('createSubFolder', ['idAdministrative' => $idAdministrative, 'folder' => $projectArray[$i]->id]) }}"
                                        class="btn btn-danger ancla"> <i class="fa fa-folder-open"
                                            aria-hidden="true"></i></a>
                                    @endcan
                                    @can('folderList')
                                    <a title="Lista de carpetas"
                                        href="{{ route('subFolderList', ['idAdministrative' => $idAdministrative, 'folder' => $projectArray[$i]->id]) }}"
                                        class="btn btn-success ancla"><i class="fa fa-archive"
                                            aria-hidden="true"></i></a>
                                    @endcan
                                    @can('deleteFolder')
                                    <a title="Eliminar carpeta"
                                        href="{{ route('deleteFolder', ['idAdministrative' => $idAdministrative, 'folder' => $projectArray[$i]->id]) }}"
                                        class="btn btn-outline-danger"
                                        onclick="return confirm( '¿Está seguro de eliminar la carpeta {{ $projectArray[$i]->place }}, tenga en cuenta que se eliminará todos los archivos que existan dentro de la misma?') "><i
                                            class="fa fa-trash-o" aria-hidden="true"></i></a>
                                    @endcan
                                </td>
                                </tr>
                                @endfor
                                @endif
                                @if (count($folderArray) != 0 && $idAdministrative!=1)
                                @for($i = 0; $i < count($folderArray); $i++) <tr>
                                    <td>{{ explode('/', $folderArray[$i])[2] }}</td>
                                    <td class="d-flex justify-content-start">
                                        @can('showFormUploadFile')
                                        <a title="Subir archivos"
                                            href="{{ route('showFormUploadFile', ['idAdministrative' => $idAdministrative, 'folder' => explode('/', $folderArray[$i])[2]]) }}"
                                            class="btn btn-secondary ancla"> <i class="fa fa-upload"
                                                aria-hidden="true"></i></a>
                                        @endcan
                                        @can('fileList')
                                        <a title="Lista de archivos"
                                            href="{{ route('fileList', ['idAdministrative' => $idAdministrative, 'folder' => explode('/', $folderArray[$i])[2]]) }}"
                                            class="btn btn-primary ancla"><i class="fa fa-list-alt"
                                                aria-hidden="true"></i></a>
                                        @endcan
                                        @can('createFolder')
                                        <a title="Nueva carpeta"
                                            href="{{ route('createSubFolder', ['idAdministrative' => $idAdministrative, 'folder' => explode('/', $folderArray[$i])[2]]) }}"
                                            class="btn btn-danger ancla"> <i class="fa fa-folder-open"
                                                aria-hidden="true"></i></a>
                                        @endcan
                                        @can('folderList')
                                        <a title="Lista de carpetas"
                                            href="{{ route('subFolderList', ['idAdministrative' => $idAdministrative, 'folder' => explode('/', $folderArray[$i])[2]]) }}"
                                            class="btn btn-success ancla"><i class="fa fa-archive"
                                                aria-hidden="true"></i></a>
                                        @endcan
                                        @can('deleteFolder')
                                        <a title="Eliminar carpeta"
                                            href="{{ route('deleteFolder', ['idAdministrative' => $idAdministrative, 'folder' => explode('/', $folderArray[$i])[2]]) }}"
                                            class="btn btn-outline-danger"
                                            onclick="return confirm( '¿Está seguro de eliminar la carpeta {{ explode('/', $folderArray[$i])[2] }}, tenga en cuenta que se eliminará todos los archivos que existan dentro de la misma?') "><i
                                                class="fa fa-trash-o" aria-hidden="true"></i></a>
                                        @endcan
                                    </td>
                                    </tr>
                                    @endfor
                                    @endif
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
