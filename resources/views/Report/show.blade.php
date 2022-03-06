@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h1 class="text-center text-primary">Archivos subidos del estudio {{ $studio->name }} del Proyecto
                            {{ $project->abbreviation }}.
                        </h1>
                    </div>
                    <div class="card-body">
                        {{-- <h2 class="h4"></h2> --}}
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Archivo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($fileName as $file)
                                    <tr>
                                        <td>
                                            {{ $file }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- @if ($id == $registre->id)
        @foreach ($fileName as $files)
            <tr>
                <td>{{ $files }}</td>
            </tr>
        @endforeach
    @endif --}}
@endsection
