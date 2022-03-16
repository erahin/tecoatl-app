@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        {{-- <h1 class="text-center text-primary">Tecoatl Asesoría Ambiental y Soluciones Alternativas S.A De C.V
                        </h1> --}}
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="body__logo">
                            <img src="{{ asset('img/tecoatl.jpeg') }}"
                                alt="Tecoatl Asesoría Ambiental y Soluciones Alternativas S.A De C.V">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
