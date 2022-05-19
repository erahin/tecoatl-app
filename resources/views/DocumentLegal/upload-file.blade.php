@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h1 class="text-center">Subir archivo
                    </h1>
                    <h2 class="h6 text-center">Ruta: <span class="text-capitalize">{{ $path }}/</span></h2>
                </div>
                <div class="card-body">
                    @if ($files)
                    <div class="row mb-3">
                        {!! Form::label('', 'Archivos subidos', ['class' => 'col-md-4 col-form-label text-md-end'])
                        !!}
                        <div class="col-md-6 scroll-studies">
                            <ul class="list-group" id="list_group">
                                @foreach ($files as $file)
                                <li class="list-group-item">
                                    {!! Form::checkbox('files[]', $file, 'true', ['class' =>
                                    'form-check-input']) !!}
                                    {{explode('/', $file)[$index+1]}} </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <hr>
                    @endif
                    {{-- <form method="POST"
                        action="{{ route('legal.upload', ['path' => str_replace('/', '-', $path)]) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @if ($files)
                        <div class="row mb-3">
                            {!! Form::label('', 'Archivos subidos', ['class' => 'col-md-4 col-form-label text-md-end'])
                            !!}
                            <div class="col-md-6 scroll-studies">
                                <ul class="list-group">
                                    @foreach ($files as $file)
                                    <li class="list-group-item">
                                        {!! Form::checkbox('files[]', $file, 'true', ['class' =>
                                        'form-check-input']) !!}
                                        {{explode('/', $file)[$index+1]}} </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <hr>
                        @endif
                        <div class="row mb-3">
                            {!! Form::label('files', 'Subir archivos', ['class' => 'col-md-4 col-form-label
                            text-md-end'])
                            !!}
                            <div class="col-md-6">
                                <button id="browseFile" class="btn btn-primary"><i class="fa fa-upload"
                                        aria-hidden="true"></i>Subir</button>
                                {{-- {!! Form::file('files-upload[]', ['class' => 'form-control', 'multiple', 'id' =>
                                'select',
                                'required', 'title' => 'Subir archivos']) !!}
                                @error('files-upload')
                                <strong class="text-danger text-center mt-5">{{ $message
                                    }}</strong>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                {{ Form::button('<i class="fa fa-upload" aria-hidden="true"></i> Subir', ['type' =>
                                'submit', 'class' =>
                                'btn btn-primary'] ) }}
                                @if (count($array) == 2)
                                <a class="btn btn-danger" href="{{ route('legal.index') }}"><i class="fa fa-ban"
                                        aria-hidden="true"></i> Cancelar
                                </a>
                                @else
                                <a class="btn btn-danger"
                                    href="{{ route('legal.folder-list', ['path' => str_replace('/', '-', $previousPath)]) }}"><i
                                        class="fa fa-ban" aria-hidden="true"></i> Cancelar
                                </a>
                                @endif
                            </div>
                        </div>
                    </form> --}}
                    <div class="row mb-3">
                        {!! Form::label('files', 'Subir archivos', ['class' => 'col-md-4 col-form-label
                        text-md-end'])
                        !!}
                        <div class="col-md-6">
                            <button id="browseFile" class="btn btn-primary ancla"><i class="fa fa-upload"
                                    aria-hidden="true"></i> Subir</button>
                            @if (count($array) == 2)
                            <a class="btn btn-danger" href="{{ route('legal.index') }}"><i class="fa fa-ban"
                                    aria-hidden="true"></i> Cancelar
                            </a>
                            @else
                            <a class="btn btn-danger"
                                href="{{ route('legal.folder-list', ['path' => str_replace('/', '-', $previousPath)]) }}"><i
                                    class="fa fa-ban" aria-hidden="true"></i> Cancelar
                            </a>
                            @endif
                        </div>
                        <div style="display: none" class="progress mt-3" style="height: 25px">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                                aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"
                                style="width: 75%; height: 100%">75%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    let browseFile = $('#browseFile');
    let resumable = new Resumable({
        target: "{{ route('legal.file',['path' => str_replace('/', '-', $path)]) }}",
        query:{_token:'{{ csrf_token() }}'} ,// CSRF token
        fileType: [],
        chunkSize: 10*1024*1024, // default is 1*1024*1024, this should be less than your maximum limit in php.ini
        headers: {
            'Accept' : 'application/json'
        },
        testChunks: false,
        throttleProgressCallbacks: 1,
    });

    resumable.assignBrowse(browseFile[0]);

    resumable.on('fileAdded', function (file) { // trigger when file picked
        showProgress();
        resumable.upload() // to actually start uploading.
    });

    resumable.on('fileProgress', function (file) { // trigger when file progress update
        updateProgress(Math.floor(file.progress() * 100));
    });

    resumable.on('fileSuccess', function (file, response) { // trigger when file upload complete
        response = JSON.parse(response)
        $('#videoPreview').attr('src', response.path);
        $('.card-footer').show();
        console.log(file.fileName);
        addFileToList(file.fileName);
    });

    resumable.on('fileError', function (file, response) { // trigger when there is any error
        alert('file uploading error.')
    });


    let progress = $('.progress');
    function showProgress() {
        progress.find('.progress-bar').css('width', '0%');
        progress.find('.progress-bar').html('0%');
        progress.find('.progress-bar').removeClass('bg-success');
        progress.show();
    }

    function updateProgress(value) {
        progress.find('.progress-bar').css('width', `${value}%`)
        progress.find('.progress-bar').html(`${value}%`)
    }

    function hideProgress() {
        progress.hide();
    }

    function addFileToList(file_name) {
        let list_group = document.getElementById("list_group");
        let ul = `<li class="list-group-item">
            {!! Form::checkbox('files[]', '', 'true', ['class' =>
            'form-check-input']) !!}
            ${file_name} </li>`;
            list_group.innerHTML += ul;
        }
</script>
@endsection
