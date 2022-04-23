@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h1 class="text-center">Lista de archivos
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
                            @if (count($files) != 0)
                            @foreach ($files as $file)
                            <tr>
                                <td>{{ explode('/', $file)[4] }}</td>
                                {{-- <td class="d-flex justify-content-start">
                                    <a title="Abrir archivos" target="_blank"
                                        href="https://torvik-dev.s3.us-east-2.amazonaws.com/{{ $file }}"
                                        class="btn btn-secondary ancla"><i class="fa fa-external-link"
                                            aria-hidden="true"></i></a>
                                    <a title="Descargar archivo"
                                        href="{{ route('downloadFileFolder', ['idAdministrative' => $idAdministrative, 'folder' => explode('/', $file)[2], 'file' => explode('/', $file)[3]]) }}"
                                        class="btn btn-primary ancla"><i class="fa fa-download"
                                            aria-hidden="true"></i></a>
                                    <a title="Eliminar archivo"
                                        href="{{ route('deleteFileFolder',['idAdministrative' => $idAdministrative, 'folder' => explode('/', $file)[2], 'file' => explode('/', $file)[3]]) }}"
                                        class="btn btn-danger"
                                        onclick="return confirm( '¿Está seguro de eliminar el archivo {{ explode('/', $file)[3] }} ?') "><i
                                            class="fa fa-trash-o" aria-hidden="true"></i></a>
                                </td> --}}
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
