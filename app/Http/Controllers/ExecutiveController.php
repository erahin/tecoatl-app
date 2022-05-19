<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;

class ExecutiveController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:config');
    }

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
        return view('DocumentExecutive.upload-file', compact('path', 'files', 'index', 'previousPath', 'array'));
    }
    public function uploadExecutiveFile(Request $request, $path)
    {
        $path = str_replace('-', '/', $path);
        $receiver = new FileReceiver('file', $request, HandlerFactory::classFromRequest($request));
        if (!$receiver->isUploaded()) {
            return 'error';
        }
        $fileReceived = $receiver->receive();
        if ($fileReceived->isFinished()) {
            $file = $fileReceived->getFile();
            $extension = $file->getClientOriginalExtension();
            $fileName = str_replace('.' . $extension, '', $file->getClientOriginalName());
            $fileName .= '.' . $extension;
            $pathToFile = $path;
            $path = Storage::disk('s3')->putFileAs($pathToFile, $file, $fileName);
            unlink($file->getPathname());
            return [
                'path' => asset('storage/' . $path),
                'filename' => $fileName
            ];
        }
        $handler = $fileReceived->handler();
        return [
            'done' => $handler->getPercentageDone(),
            'status' => true
        ];
    }
    public function executiveFilesList($path)
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
        return view('DocumentExecutive.file-list', compact('path', 'files', 'index', 'previousPath', 'array'));
    }
    public function deleteFolder($path)
    {
        $path = str_replace('-', '/', $path);
        $array = explode('/', $path);
        Storage::disk('s3')->deleteDirectory($path);
        if (count($array) == 2) {
            return redirect()->route('directivo.index');
        } else {
            $previousPath = "";
            for ($i = 0; $i < count($array); $i++) {
                if ($i == count($array) - 1) {
                    $index = $i;
                } else {
                    $previousPath .= $array[$i] . '/';
                }
            }
            $previousPath = rtrim($previousPath, '/');
            return redirect()->route('directivo.folder-list', ['path' => str_replace('/', '-', $previousPath)]);
        }
    }
    public function downloadExecutiveFile($path)
    {
        $path = str_replace('+', '/', $path);
        $pathToFile = Storage::disk('s3')->path($path);
        if (Storage::disk('s3')->exists($pathToFile)) {
            return Storage::disk('s3')->download($pathToFile);
        } else {
            return view('errors.4032');
        }
    }
    public function deleteExecutiveFile($path)
    {
        $path = str_replace('+', '/', $path);
        $array = explode('/', $path);
        Storage::disk('s3')->delete($path);
        if (count($array) == 2) {
            return redirect()->route('directivo.fileList', ['path' => str_replace('/', '-', $path)]);
        } else {
            $previousPath = "";
            for ($i = 0; $i < count($array); $i++) {
                if ($i == count($array) - 1) {
                    $index = $i;
                } else {
                    $previousPath .= $array[$i] . '/';
                }
            }
            $previousPath = rtrim($previousPath, '/');
            return redirect()->route('directivo.fileList', ['path' => str_replace('/', '-', $previousPath)]);
        }
    }
}
