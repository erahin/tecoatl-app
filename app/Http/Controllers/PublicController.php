<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;

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
    public function uploadFileForm($path)
    {
        $path = str_replace('-', '/', $path);
        $files = Storage::disk('s3')->allFiles($path . '/');
        return view('DocumentPublic.upload-file', compact('path', 'files'));
    }
    public function uploadPublicFile(Request $request, $path)
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
    public function publicFilesList($path)
    {
        $path = str_replace('-', '/', $path);
        $files = Storage::disk('s3')->allFiles($path . '/');
        return view('DocumentPublic.file-list', compact('path', 'files'));
    }
    public function deleteFolder($path)
    {
        $path = str_replace('-', '/', $path);
        Storage::disk('s3')->deleteDirectory($path);
        return redirect()->route('publico.index');
    }
    public function downloadPublicFile($folder, $subfolder, $file)
    {
        $pathToFile = Storage::disk('s3')->path($folder . '/' . $subfolder . '/' . $file);
        if (Storage::disk('s3')->exists($pathToFile)) {
            return Storage::disk('s3')->download($pathToFile);
        } else {
            return view('errors.4032');
        }
    }
    public function deletePublicFile($folder, $subfolder, $file)
    {
        Storage::disk('s3')->delete($folder . '/' . $subfolder . '/' . $file);
        return redirect()->route('publicFilesList', ['path' => $folder . '-' . $subfolder]);
    }
}
