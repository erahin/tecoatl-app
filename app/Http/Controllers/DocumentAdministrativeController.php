<?php

namespace App\Http\Controllers;

use App\Models\Administrative;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentAdministrativeController extends Controller
{

    public function createFolder($idAdministrative)
    {
        $administrative = Administrative::find($idAdministrative);
        if ($administrative == null) {
            return view('errors.4032');
        }
        return view('DocumentAdministrative.create', compact('idAdministrative'));
    }
    public function storeFolder(Request $request, $idAdministrative)
    {
        $administrative = Administrative::find($idAdministrative);
        if ($administrative == null) {
            return view('errors.4032');
        }
        $request->validate([
            'name' => ['string', 'confirmed']
        ]);
        /* -------------------------------------------------------------------------- */
        /*                           Create sub departamet subdirectory               */
        /* -------------------------------------------------------------------------- */
        Storage::disk('s3')->makeDirectory('administrativo/' . $idAdministrative . '/' . $request->name);
        return redirect()->route('administrativos.index');
    }
    public function folderList($idAdministrative)
    {
        $administrative = Administrative::find($idAdministrative);
        if ($administrative == null) {
            return view('errors.4032');
        }
        $directories = Storage::disk('s3')->directories('administrativo/' . $idAdministrative . '/');
        $folderArray = [];
        foreach ($directories as $directorie) {
            array_push($folderArray, $directorie);
        }
        return view('DocumentAdministrative.index-folder', compact('folderArray', 'idAdministrative'));
    }
    public function showFormUploadFile($idAdministrative, $folder)
    {
        $administrative = Administrative::find($idAdministrative);
        if ($administrative == null) {
            return view('errors.4032');
        }
        /* -------------------------------------------------------------------------- */
        /*                                Get all files                               */
        /* -------------------------------------------------------------------------- */
        $files = Storage::disk('s3')->files('administrativo/' . $idAdministrative . '/' . $folder . '/');
        return view('DocumentAdministrative.upload-file', compact('idAdministrative', 'administrative', 'files', 'folder'));
    }
    public function uploadFile(Request $request, $idAdministrative, $folder)
    {
        $administrative = Administrative::find($idAdministrative);
        if ($administrative == null) {
            return view('errors.4032');
        }
        $request->validate([
            'files-upload' => ['required'],
        ]);
        /* -------------------------------------------------------------------------- */
        /*                          Insert files to directory                         */
        /* -------------------------------------------------------------------------- */
        foreach ($request->file('files-upload') as $fileRequest) {
            $file = $fileRequest;
            $fileName = $fileRequest->getClientOriginalName();
            $filePath = 'administrativo/' . $idAdministrative . '/' . $folder . '/' . $fileName;
            Storage::disk('s3')->put($filePath, file_get_contents($file));
        }
        return redirect()->route('folderList', ['idAdministrative' => $idAdministrative]);
    }
    public function fileList($idAdministrative, $folder)
    {
        $administrative = Administrative::find($idAdministrative);
        if ($administrative == null) {
            return view('errors.4032');
        }
        $files = Storage::disk('s3')->files('administrativo/' . $idAdministrative . '/' . $folder . '/');
        return view('DocumentAdministrative.file-list', compact('files', 'idAdministrative'));
    }
    public function deleteFolder($idAdministrative, $folder)
    {
        /* -------------------------------------------------------------------------- */
        /*                                  Validate                                  */
        /* -------------------------------------------------------------------------- */
        $administrative = Administrative::find($idAdministrative);
        if ($administrative == null) {
            return view('errors.4032');
        }
        /* -------------------------------------------------------------------------- */
        /*                              Delete directory                              */
        /* -------------------------------------------------------------------------- */
        Storage::disk('s3')->deleteDirectory('administrativo/' . $idAdministrative . '/' . $folder . '/');
        return redirect()->route('folderList', ['idAdministrative' => $idAdministrative]);
    }
    public function downloadFileFolder($idAdministrative, $folder, $file)
    {
        $administrative = Administrative::find($idAdministrative);
        if ($administrative == null) {
            return view('errors.4032');
        }
        $pathToFile = Storage::disk('s3')->path('administrativo/' . $idAdministrative . '/' . $folder . '/' . $file);
        return Storage::disk('s3')->download($pathToFile);
    }
    public function createSubFolder($idAdministrative, $folder)
    {
        $administrative = Administrative::find($idAdministrative);
        if ($administrative == null) {
            return view('errors.4032');
        }
        $directories = Storage::disk('s3')->directories('administrativo/' . $idAdministrative . '/' . $folder . '/');
        return view('DocumentAdministrative.create-subfolder', compact('idAdministrative', 'folder', 'directories'));
    }
    public function storeSubFolder(Request $request, $idAdministrative, $folder)
    {
        $administrative = Administrative::find($idAdministrative);
        if ($administrative == null) {
            return view('errors.4032');
        }
        $request->validate([
            'name' => ['string', 'confirmed']
        ]);
        /* -------------------------------------------------------------------------- */
        /*                           Create sub departamet subdirectory               */
        /* -------------------------------------------------------------------------- */
        Storage::disk('s3')->makeDirectory('administrativo/' . $idAdministrative . '/' . $folder . '/' . $request->name . '/');
        return redirect()->route('folderList', ['idAdministrative' => $idAdministrative]);
    }
    public function subFolderList($idAdministrative, $folder)
    {
        $administrative = Administrative::find($idAdministrative);
        if ($administrative == null) {
            return view('errors.4032');
        }
        $directories = Storage::disk('s3')->directories('administrativo/' . $idAdministrative . '/' . $folder . '/');
        $folderArray = [];
        foreach ($directories as $directorie) {
            array_push($folderArray, $directorie);
        }
        return view('DocumentAdministrative.index-subfolder', compact('administrative', 'folderArray', 'folder', 'idAdministrative'));
    }
    public function showFormUploadFileSubFolder($idAdministrative, $folder, $subfolder)
    {
        $administrative = Administrative::find($idAdministrative);
        if ($administrative == null) {
            return view('errors.4032');
        }
        /* -------------------------------------------------------------------------- */
        /*                                Get all files                               */
        /* -------------------------------------------------------------------------- */
        $files = Storage::disk('s3')->files('administrativo/' . $idAdministrative . '/' . $folder . '/' . $subfolder . '/');
        return view('DocumentAdministrative.upload-file-subfolder', compact('idAdministrative', 'administrative', 'files', 'folder', 'subfolder'));
    }
    public function uploadFileSubFolder(Request $request, $idAdministrative, $folder, $subfolder)
    {
        $administrative = Administrative::find($idAdministrative);
        if ($administrative == null) {
            return view('errors.4032');
        }
        $request->validate([
            'files-upload' => ['required'],
        ]);
        /* -------------------------------------------------------------------------- */
        /*                          Insert files to directory                         */
        /* -------------------------------------------------------------------------- */
        foreach ($request->file('files-upload') as $fileRequest) {
            $file = $fileRequest;
            $fileName = $fileRequest->getClientOriginalName();
            $filePath = 'administrativo/' . $idAdministrative . '/' . $folder . '/' . $subfolder . '/' . $fileName;
            Storage::disk('s3')->put($filePath, file_get_contents($file));
        }
        return redirect()->route('subFolderList', ['idAdministrative' => $idAdministrative, 'folder' => $folder]);
    }
    public function subFolderFileList($idAdministrative, $folder, $subfolder)
    {
        $administrative = Administrative::find($idAdministrative);
        if ($administrative == null) {
            return view('errors.4032');
        }
        $files = Storage::disk('s3')->files('administrativo/' . $idAdministrative . '/' . $folder . '/' . $subfolder . '/');
        return view('DocumentAdministrative.file-list-subfolder', compact('files', 'idAdministrative', 'folder', 'subfolder'));
    }
    public function deleteSubFolder($idAdministrative, $folder, $subfolder)
    {
        /* -------------------------------------------------------------------------- */
        /*                                  Validate                                  */
        /* -------------------------------------------------------------------------- */
        $administrative = Administrative::find($idAdministrative);
        if ($administrative == null) {
            return view('errors.4032');
        }
        /* -------------------------------------------------------------------------- */
        /*                              Delete directory                              */
        /* -------------------------------------------------------------------------- */
        Storage::disk('s3')->deleteDirectory('administrativo/' . $idAdministrative . '/' . $folder . '/' . $subfolder . '/');
        return redirect()->route('subFolderList', ['idAdministrative' => $idAdministrative, 'folder' => $folder]);
    }
    public function downloadFileSubFolder($idAdministrative, $folder, $subfolder, $file)
    {
        $administrative = Administrative::find($idAdministrative);
        if ($administrative == null) {
            return view('errors.4032');
        }
        $pathToFile = Storage::disk('s3')->path('administrativo/' . $idAdministrative . '/' . $folder . '/' . $subfolder . '/' . $file);
        return Storage::disk('s3')->download($pathToFile);
    }
    public function deleteFileFolder($idAdministrative, $folder, $file)
    {
        $administrative = Administrative::find($idAdministrative);
        if ($administrative == null) {
            return view('errors.4032');
        }
        Storage::disk('s3')->delete('administrativo/' . $idAdministrative . '/' . $folder . '/' . $file);
        return redirect()->route('fileList', ['idAdministrative' => $idAdministrative, 'folder' => $folder]);
    }
    public function deleteFileSubFolder($idAdministrative, $folder, $subfolder, $file)
    {
        $administrative = Administrative::find($idAdministrative);
        if ($administrative == null) {
            return view('errors.4032');
        }
        Storage::disk('s3')->delete('administrativo/' . $idAdministrative . '/' . $folder . '/' . $subfolder . '/' . $file);
        return redirect()->route('subFolderFileList', ['idAdministrative' => $idAdministrative, 'folder' => $folder, 'subfolder' => $subfolder]);
    }
}
