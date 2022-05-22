@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h1 class="text-center">Editar departamento administrativo
                    </h1>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('administrativos.update', $administrative->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            {!! Form::label('name', 'Nombre del departamento', ['class' => 'col-md-4 col-form-label
                            text-md-end']) !!}
                            <div class="col-md-6">
                                {!! Form::text('name', $administrative->name, ['class' => 'form-control', 'required',
                                'autofocus','id'=>'departament','onkeyup' => 'firstLetterToCapitalize(departament);'])
                                !!}
                                @error('name')
                                <strong class="text-danger text-center mt-5">{{ $message
                                    }}</strong>
                                @enderror
                            </div>
                        </div>
                        {{-- <div class="row mb-3">
                            {!! Form::label('', 'Encargado', ['class' => 'col-md-4 col-form-label
                            text-md-end'])
                            !!}
                            <div class="col-md-6">
                                <div class="form-check scroll-studies">
                                    @foreach ($userArray as $user)
                                    <label class="form-check-label inline_label">
                                        {!! Form::checkbox('user_id', $user->id, null, ['class' =>
                                        'form-check-input', 'id' => $user->id]) !!}
                                        {{ $user->name }}
                                    </label>
                                    @endforeach
                                </div>
                                @error('user_id')
                                <strong class="text-danger text-center mt-5">{{ $message
                                    }}</strong>
                                @enderror
                            </div>
                        </div> --}}
                        <div class="row mb-3">
                            <label for="exampleFormControlSelect1"
                                class="col-md-4 col-form-label text-md-end">Encargado</label>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <select class="form-select" id="exampleFormControlSelect1" name="user_id">
                                        <option selected disabled value="">Escoja el encargado</option>
                                        @foreach ($userArray as $user)
                                        @if ($user->id == $administrative->user_id)
                                        <option selected value="{{ $user->id }}">{{ $user->name }}</option>
                                        @else
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                                @error('user_id')
                                <strong class="text-danger text-center mt-5">{{ $message
                                    }}</strong>
                                @enderror
                            </div>
                        </div>
                        {{-- @foreach ($userArray as $user)
                        @if ($administrative->user_id == $user->id)
                        <script>
                            checkActive({{ $user->id}});

                                function checkActive(idUser) {
                                    let id = idUser;
                                    let checkUser = document.getElementById(
                                        id
                                    );
                                    checkUser.setAttribute("checked", "");
                                }
                        </script>
                        @endif
                        @endforeach --}}
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                {{ Form::button('<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar',
                                ['type' =>
                                'submit', 'class' =>
                                'btn btn-primary'] ) }}
                                <a class="btn btn-danger" href="{{ route('administrativos.index') }}"><i
                                        class="fa fa-ban" aria-hidden="true"></i>
                                    Cancelar
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
