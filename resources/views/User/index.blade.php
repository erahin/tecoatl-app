@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h1 class="text-center text-primary">Lista de Usuarios.
                    </h1>
                </div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <a class="btn btn-primary my-2" href="{{ route('usuarios.create') }}" role="button">Crear
                        Usuario</a>
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Nombre de usuario</th>
                                <th scope="col">Correo</th>
                                <th scope="col" colspan="2">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td><a href="{{ route('usuarios.edit', $user->id) }}" class="btn btn-success">Editar</a>
                                </td>
                                <td>
                                    <form action="{{ route('usuarios.destroy', $user->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <input type="submit" value="Eliminar" class="btn btn-danger"
                                            onclick="return confirm( '¿Está seguro de eliminar {{ $user->name }}?') ">
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
