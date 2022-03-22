@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h1 class="text-center text-primary">Lista de Usuarios.
                    </h1>
                    <div>
                        <form action="{{ route('usuarios.index') }}" class="input-group d-flex justify-content-end">
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
                        <a class="btn btn-primary my-2 ancla" href="{{ route('usuarios.create') }}" role="button"><i
                                class="fa fa-plus" aria-hidden="true"></i> Crear
                            Usuario</a>
                        <a class=" btn btn-secondary my-2" href="{{ route('usuarios.index') }}" role="button">
                            <i class="fa fa-list" aria-hidden="true"></i> Lista completa</a>
                    </div>
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Nombre de usuario</th>
                                <th scope="col">Correo</th>
                                <th scope="col" colspan="2">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($users) != 0)
                            @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td class="d-flex justify-content-start"><a
                                        href="{{ route('usuarios.edit', $user->id) }}" class="btn btn-success ancla"><i
                                            class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar</a>
                                    <form action="{{ route('usuarios.destroy', $user->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger"
                                            onclick="return confirm( '¿Está seguro de eliminar {{ $user->name }}?') "><i
                                                class="fa fa-trash-o" aria-hidden="true"></i>
                                            Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="4">No existen usuarios.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
