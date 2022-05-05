<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExecutiveController extends Controller
{
    public function index()
    {
        $folders = Storage::disk('s3')->directories('directivo/');
        return view('DocumentExecutive.index', compact('folders'));
    }
    public function create()
    {
        $folders = Storage::disk('s3')->directories('directivo/');
        return view('DocumentExecutive.showForm', compact('folders'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'confirmed']
        ]);
        Storage::disk('s3')->makeDirectory('directivo/' . $request->name);
        return redirect()->route('directivo.index');
    }
    public function uploadFileForm($path)
    {
        $path = str_replace('-', '/', $path);
        $files = Storage::disk('s3')->allFiles($path . '/');
        return view('DocumentExecutive.upload-file', compact('path', 'files'));
    }
    public function uploadExecutiveFile(Request $request, $path)
    {
        $request->validate([
            'files-upload' => ['required']
        ]);
        $path = str_replace('-', '/', $path);
        foreach ($request->file('files-upload') as $fileRequest) {
            $file = $fileRequest;
            $fileName = $fileRequest->getClientOriginalName();
            $filePath = $path . '/' . $fileName;
            Storage::disk('s3')->put($filePath, file_get_contents($file));
            set_time_limit(60);
        }
        return redirect()->route('directivo.index');
    }
    public function executiveFilesList($path)
    {
        $path = str_replace('-', '/', $path);
        $files = Storage::disk('s3')->allFiles($path . '/');
        return view('DocumentExecutive.file-list', compact('path', 'files'));
    }
    public function deleteFolder($path)
    {
        $path = str_replace('-', '/', $path);
        Storage::disk('s3')->deleteDirectory($path);
        return redirect()->route('directivo.index');
    }
    public function downloadExecutiveFile($folder, $subfolder, $file)
    {
        $pathToFile = Storage::disk('s3')->path($folder . '/' . $subfolder . '/' . $file);
        if (Storage::disk('s3')->exists($pathToFile)) {
            return Storage::disk('s3')->download($pathToFile);
        } else {
            return view('errors.4032');
        }
    }
    public function deleteExecutiveFile($folder, $subfolder, $file)
    {
        Storage::disk('s3')->delete($folder . '/' . $subfolder . '/' . $file);
        return redirect()->route('publicFilesList', ['path' => $folder . '-' . $subfolder]);
    }
}
