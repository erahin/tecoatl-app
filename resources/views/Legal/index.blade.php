@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h1 class="text-center">Lista de departamentos legales
                    </h1>
                    <div>
                        <form action="{{ route('legal.index') }}" class="input-group d-flex justify-content-end">
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
                        @can('legal.create')
                        <a class="btn btn-primary my-2 ancla" href="{{ route('legal.create') }}" role="button"><i
                                class="fa fa-plus" aria-hidden="true"></i> Crear
                            departamento</a>
                        @endcan
                        <a class=" btn btn-secondary my-2" href="{{ route('legal.index') }}" role="button">
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
                            @if (count($legals) != 0)
                            @foreach ($legals as $legal)
                            <tr>
                                <td>{{ $legal->name }}</td>
                                <td class="d-flex justify-content-start">
                                    @can('legal.create-subfolder')
                                    @if ($isLegalUser == true)
                                    @if ($legal->user_id == Auth::user()->id)
                                    <a title="Nueva carpeta"
                                        href="{{ route('legal.create-subfolder', ['path' => 'legal'. '-' . $legal->name]) }}"
                                        class="btn btn-secondary ancla"> <i class="fa fa-folder-open"
                                            aria-hidden="true"></i></a>
                                    @endif
                                    @else
                                    <a title="Nueva carpeta"
                                        href="{{ route('legal.create-subfolder', ['path' => 'legal'. '-' . $legal->name]) }}"
                                        class="btn btn-secondary ancla"> <i class="fa fa-folder-open"
                                            aria-hidden="true"></i></a>
                                    @endif
                                    @endcan
                                    {{-- start --}}
                                    @can('legal.fileList')
                                    @if ($isLegalUser == true)
                                    @if ($legal->user_id == Auth::user()->id)
                                    <a title="Lista de carpetas"
                                        href="{{ route('legal.folder-list', ['path' => 'legal'. '-' . $legal->name]) }}"
                                        class="btn btn-primary ancla"><i class="fa fa-archive"
                                            aria-hidden="true"></i></a>
                                    @endif
                                    @else
                                    <a title="Lista de carpetas"
                                        href="{{ route('legal.folder-list', ['path' => 'legal'. '-' . $legal->name]) }}"
                                        class="btn btn-primary ancla"><i class="fa fa-archive"
                                            aria-hidden="true"></i></a>
                                    @endif
                                    @endcan
                                    {{-- start --}}
                                    @can('legal.createUpload')
                                    @if ($isLegalUser == true)
                                    @if ($legal->user_id == Auth::user()->id)
                                    <a title="Subir archivos"
                                        href="{{ route('legal.createUpload', ['path' => 'legal'. '-' . $legal->name]) }}"
                                        class="btn btn-outline-success ancla"> <i class="fa fa-upload"
                                            aria-hidden="true"></i></a>
                                    @endif
                                    @else
                                    <a title="Subir archivos"
                                        href="{{ route('legal.createUpload', ['path' => 'legal'. '-' . $legal->name]) }}"
                                        class="btn btn-outline-success ancla"> <i class="fa fa-upload"
                                            aria-hidden="true"></i></a>
                                    @endif
                                    @endcan
                                    @can('legal.createUpload')
                                    <a title="Lista de archivos"
                                        href="{{ route('legal.fileList', ['path' => 'legal'. '-' . $legal->name]) }}"
                                        class="btn btn-outline-primary ancla"><i class="fa fa-list-alt"
                                            aria-hidden="true"></i></a>
                                    @endcan
                                    @can('legal.edit')
                                    <a title="Editar" href="{{ route('legal.edit', $legal->id) }}"
                                        class="btn btn-success ancla"><i class="fa fa-pencil-square-o"
                                            aria-hidden="true"></i></a>
                                    @endcan
                                    @can('legal.destroy')
                                    <form action="{{ route('legal.destroy', $legal->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button title="Eliminar" type="submit" class="btn btn-danger"
                                            onclick="return confirm( '¿Está seguro de eliminar {{ $legal->name }}?') "><i
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
                    {{ $legals->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
