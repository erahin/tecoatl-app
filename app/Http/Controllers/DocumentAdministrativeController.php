<?php

namespace App\Http\Controllers;

use App\Models\Administrative;
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
        $directories = Storage::disk('s3')->allDirectories('administrativo/' . $idAdministrative . '/');
        $folderArray = [];
        foreach ($directories as $directorie) {
            array_push($folderArray, $directorie);
        }
        return view('Administrative.index-folder', compact('folderArray', 'idAdministrative'));
    }
    public function uploadFile()
    {
    }
    public function fileList($idAdministrative, $folder)
    {
        $administrative = Administrative::find($idAdministrative);
        if ($administrative == null) {
            return view('errors.4032');
        }
        $files = Storage::disk('s3')->allFiles('administrativo/' . $idAdministrative . '/' . $folder . '/');
        return view('Administrative.file-list', compact('files', 'idAdministrative'));
    }
    public function subFolderList()
    {
    }
    public function createSubFolder($idAdministrative)
    {
        $administrative = Administrative::find($idAdministrative);
        if ($administrative == null) {
            return view('errors.4032');
        }
        return view('DocumentAdministrative.create', compact('idAdministrative'));
    }
    public function storeSubFolder(Request $request, $idAdministrative)
    {
        $request->validate([
            'name' => ['string', 'confirmed']
        ]);
        /* -------------------------------------------------------------------------- */
        /*                           Create sub departamet subdirectory               */
        /* -------------------------------------------------------------------------- */
        Storage::disk('s3')->makeDirectory('administrativo/' . $idAdministrative . '/' . $request->name);
        return redirect()->route('administrativos.index');
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
    public function deleteFileFolder($idAdministrative, $folder, $file)
    {
        $administrative = Administrative::find($idAdministrative);
        if ($administrative == null) {
            return view('errors.4032');
        }
        Storage::disk('s3')->delete('administrativo/' . $idAdministrative . '/' . $folder . '/' . $file);
        return redirect()->route('fileList', ['idAdministrative' => $idAdministrative, 'folder' => $folder]);
    }
}
