@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h1 class="text-center text-primary">Crear Proyecto.
                        </h1>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('proyectos.store') }}">
                            @csrf
                            <div class="row mb-3">
                                <label for="place" class="col-md-4 col-form-label text-md-end">{{ __('Lugar') }}</label>

                                <div class="col-md-6">
                                    <input id="place" type="text" class="form-control @error('place') is-invalid @enderror"
                                        name="place" value="{{ old('name') }}" required autocomplete="place" autofocus>

                                    @error('place')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="abbreviation"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Abreviación') }}</label>

                                <div class="col-md-6">
                                    <input id="abbreviation" type="abbreviation" class="form-control @error('abbreviation') is-invalid @enderror"
                                        name="abbreviation" value="{{ old('abbreviation') }}" required autocomplete="abbreviation">

                                    @error('abbreviation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                             <div class="form-group">
                                    <label for="region_id">Región</label>
                                    <select class="form-control" id="region_id">
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                    </select>
                            </div>

  
                            <div class="custom-file" >
                                <input type="file" class="custom-file-input" id="customFileLang" lang="es">
                            <label class="custom-file-label" for="customFileLang">Seleccionar Archivo</label>
                            </div>
                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Crear') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
