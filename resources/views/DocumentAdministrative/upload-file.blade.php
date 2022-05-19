@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h1 class="text-center">Subir archivo
                    </h1>
                    @if ($project!= null)
                    <h2 class="h6 text-center">Ruta: Administrativo/{{ $administrative->name }}/{{ $project->place }}/
                    </h2>
                    @else
                    <h2 class="h6 text-center">Ruta: Administrativo/{{ $administrative->name }}/{{ $folder }}/</h2>
                    @endif
                </div>
                <div class="card-body">
                    <div id="div_file">
                    </div>
                    <div class="row mb-3">
                        {!! Form::label('files', 'Subir archivos', ['class' => 'col-md-4 col-form-label
                        text-md-end'])
                        !!}
                        <div class="col-md-6">
                            {!! Form::file('files', ['class' => 'form-control', 'multiple', 'id' =>
                            'browseFile',
                            'required', 'title' => 'Subir archivos']) !!}
                        </div>
                    </div>
                    <div class="row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <a class="btn btn-primary ancla"
                                href="{{ route('folderList', ['idAdministrative' => $administrative->id]) }}"><i
                                    class=" fa fa-chevron-left" aria-hidden="true"></i>
                                Regresar
                            </a>
                            <a class="btn btn-danger" id="btn-cancel"><i class="fa fa-ban" aria-hidden="true"></i>
                                Cancelar
                            </a>
                        </div>
                        <div style="display: none" class="progress mt-3" style="height: 25px">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning"
                                role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"
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
        target: "{{ route('uploadFile', ['idAdministrative' => $administrative->id, 'folder' => $folder]) }}"
        , query: {
            _token: '{{ csrf_token() }}'
        }, // CSRF token
        fileType: []
        , chunkSize: 10 * 1024 * 1024, // default is 1*1024*1024, this should be less than your maximum limit in php.ini
        headers: {
            'Accept': 'application/json'
        }
        , testChunks: false
        , throttleProgressCallbacks: 1
    , });

    resumable.assignBrowse(browseFile[0]);

    resumable.on('fileAdded', function(file) { // trigger when file picked
        showProgress();
        resumable.upload() // to actually start uploading.
    });

    resumable.on('fileProgress', function(file) { // trigger when file progress update
        updateProgress(Math.floor(file.progress() * 100));
    });

    resumable.on('fileSuccess', function(file, response) { // trigger when file upload complete
        response = JSON.parse(response)
        $('#videoPreview').attr('src', response.path);
        $('.card-footer').show();
        addFileToList(file.fileName);
    });

    resumable.on('fileError', function(file, response) { // trigger when there is any error
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
    (function() {
        let count_files = {{ count($files) }};
        if (count_files != 0) {
            createFileList();
        }
    })();

    function createFileList() {
        let div_files = document.getElementById("div_file");
        let list = `<div class="row mb-3">
        {!! Form::label('', 'Archivos subidos', ['class' => 'col-md-4 col-form-label
        text-md-end'])
        !!}
        <div class="col-md-6 scroll-studies">
            <ul class="list-group" id="list_group">
                @foreach ($files as $file)
                <li class="list-group-item">
                    {!! Form::checkbox('files[]', $file, 'true', ['class' =>
                    'form-check-input']) !!}
                    {{explode('/', $file)[3]}} </li>
                @endforeach
            </ul>
        </div>
    </div>
    <hr>`;
        div_files.innerHTML = list;
    }

    function addFileToList(file_name) {
        let list_group = document.getElementById("list_group");
        if (list_group == null) {
            createFileList();
            let list_group = document.getElementById("list_group");
            let ul = `<li class="list-group-item">
                {!! Form::checkbox('files[]', '', 'true', ['class' =>
                'form-check-input']) !!}
                ${file_name} </li>`;
            list_group.innerHTML = ul;
        } else {
            let ul = `<li class="list-group-item">
                {!! Form::checkbox('files[]', '', 'true', ['class' =>
                'form-check-input']) !!}
                ${file_name} </li>`;
            list_group.innerHTML += ul;
        }

    }
    let btn_cancel = document.getElementById("btn-cancel");
    btn_cancel.addEventListener("click", cancelUpload);

    function cancelUpload() {
        resumable.cancel();
    }

</script>
@endsection
