<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class PublicController extends Controller
{
    public function index()
    {
        $folders = Storage::disk('s3')->directories('publico/');
        return view('DocumentPublic.index', compact('folders'));
    }
    public function create()
    {
        $folders = Storage::disk('s3')->directories('publico/');
        return view('DocumentPublic.showForm', compact('folders'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'confirmed']
        ]);
        Storage::disk('s3')->makeDirectory('publico/' . $request->name);
        return redirect()->route('publico.index');
    }
    public function createFolder($path)
    {
        $path = str_replace('-', '/', $path);
        $array = explode('/', $path);
        $index = -1;
        // return count($array);
        for ($i = 0; $i < count($array); $i++) {
            if ($i == count($array) - 1) {
                $index = $i;
            }
        }
        $folders = Storage::disk('s3')->directories($path . '/');
        return view('DocumentPublic.create', compact('path', 'folders', 'index'));
    }
    public function storeFolder(Request $request, $path, $route)
    {
        $request->validate([
            'name' => ['required', 'confirmed']
        ]);
        $path = str_replace('-', '/', $path);
        Storage::disk('s3')->makeDirectory($path . '/' . $request->name);
        return redirect()->route($route);
    }
    public function uploadFileForm($path)
    {
        return view('DocumentPublic.upload-file', compact('path'));
    }
    public function uploadFile(Request $request, $path, $route)
    {
        $request->validate([
            'files' => ['required']
        ]);
        foreach ($request->file('files') as $fileRequest) {
            $file = $fileRequest;
            $fileName = $fileRequest->getClientOriginalName();
            $filePath = $path . '/' . $fileName;
            File::streamUpload($filePath, $fileName, $file, true);
            set_time_limit(60);
        }
        return redirect()->route($route);
    }
    public function deleteFolder($path)
    {
        $path = str_replace('-', '/', $path);
        Storage::disk('s3')->deleteDirectory($path);
        return redirect()->route('publico.index');
    }
    public function downloadFile($path, $file)
    {
        $pathToFile = Storage::disk('s3')->path($path . '/' . $file);
        return Storage::disk('s3')->download($pathToFile);
    }
    public function deleteFile($path, $file, $route)
    {
        Storage::disk('s3')->delete($path . $file);
        return redirect()->route($route);
    }
}
