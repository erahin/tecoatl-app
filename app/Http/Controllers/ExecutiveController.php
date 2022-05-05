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
    public function createFolder($path)
    {
        $path = str_replace('-', '/', $path);
        $array = explode('/', $path);
        $index = -1;
        for ($i = 0; $i < count($array); $i++) {
            if ($i == count($array) - 1) {
                $index = $i;
            }
        }
        $folders = Storage::disk('s3')->directories($path . '/');
        return view('DocumentExecutive.create', compact('path', 'folders', 'index'));
    }
    public function storeFolder(Request $request, $path)
    {
        $request->validate([
            'name' => ['required', 'confirmed']
        ]);
        $path = str_replace('-', '/', $path);
        Storage::disk('s3')->makeDirectory($path . '/' . $request->name);
        return redirect()->route('directivo.index');
    }
    public function folderList($path)
    {
        $path = str_replace('-', '/', $path);
        $array = explode('/', $path);
        $index = -1;
        for ($i = 0; $i < count($array); $i++) {
            if ($i == count($array) - 1) {
                $index = $i;
            }
        }
        $directories = Storage::disk('s3')->directories($path);
        return view('DocumentExecutive.index-folder', compact('directories', 'index', 'path'));
    }
    public function uploadFileForm($path)
    {
        $path = str_replace('-', '/', $path);
        $array = explode('/', $path);
        $index = -1;
        $previousPath = "";
        for ($i = 0; $i < count($array); $i++) {
            if ($i == count($array) - 1) {
                $index = $i;
            } else {
                $previousPath .= $array[$i] . '/';
            }
        }
        $previousPath = rtrim($previousPath, '/');
        $files = Storage::disk('s3')->files($path . '/');
        // dd($files);
        return view('DocumentExecutive.upload-file', compact('path', 'files', 'index', 'previousPath', 'array'));
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
        $array = explode('/', $path);
        if (count($array) == 2) {
            return redirect()->route('directivo.index');
        } else {
            // $index = -1;
            $previousPath = "";
            for ($i = 0; $i < count($array); $i++) {
                if ($i == count($array) - 1) {
                    $index = $i;
                    // $previousPath .= $array[$i] . '/';
                } else {
                    $previousPath .= $array[$i] . '/';
                }
            }
            $previousPath = rtrim($previousPath, '/');
            // dd($previousPath);
            return redirect()->route('directivo.folder-list', ['path' => str_replace('/', '-', $previousPath)]);
        }
    }
    public function executiveFilesList($path)
    {
        $path = str_replace('-', '/', $path);
        $files = Storage::disk('s3')->files($path . '/');
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
        return redirect()->route('directivo.fileList', ['path' => $folder . '-' . $subfolder]);
    }
}
