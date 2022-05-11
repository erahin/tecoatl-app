<?php

namespace App\Http\Controllers;

use App\Models\Legal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DocumentLegalController extends Controller
{
    public function createFolder($path)
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
        $folders = Storage::disk('s3')->directories($path . '/');
        /* -------------------------------------------------------------------------- */
        /*                                Validate user                               */
        /* -------------------------------------------------------------------------- */
        $user = Auth::user();
        $idUser = $user->id;
        $isLegalUser = false;
        $users = DB::select('select * from model_has_roles where model_id = ?', [$idUser]);
        foreach ($users as $user) {
            if ($user->role_id == 7) {
                $isLegalUser = true;
                $legal = DB::select('select user_id from legals where name = ?', [$array[1]]);
                if ($idUser == $legal[0]->user_id) {
                    return view('DocumentLegal.create', compact('path', 'folders', 'index', 'previousPath', 'array'));
                } else {
                    return view('errors.4032');
                }
            }
        }
        return view('DocumentLegal.create', compact('path', 'folders', 'index', 'previousPath', 'array'));
    }
    public function storeFolder(Request $request, $path)
    {
        $request->validate([
            'name' => ['required', 'confirmed']
        ]);
        $path = str_replace('-', '/', $path);
        Storage::disk('s3')->makeDirectory($path . '/' . $request->name);
        $array = explode('/', $path);
        if (count($array) == 2) {
            return redirect()->route('legal.index');
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
            return redirect()->route('legal.folder-list', ['path' => str_replace('/', '-', $previousPath)]);
        }
    }
    public function folderList($path)
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
        if (count($array) == 2) {
            $homepath = "";
        } else {
            $homepath = explode('/', $previousPath)[0] . '/' . explode('/', $previousPath)[1];
        }
        $directories = Storage::disk('s3')->directories($path);
        /* -------------------------------------------------------------------------- */
        /*                                Validate user                               */
        /* -------------------------------------------------------------------------- */
        $user = Auth::user();
        $idUser = $user->id;
        $isLegalUser = false;
        $users = DB::select('select * from model_has_roles where model_id = ?', [$idUser]);
        foreach ($users as $user) {
            if ($user->role_id == 7) {
                $isLegalUser = true;
                $legal = DB::select('select user_id from legals where name = ?', [$array[1]]);
                if ($idUser == $legal[0]->user_id) {
                    return view('DocumentLegal.index-folder', compact('directories', 'index', 'path', 'previousPath', 'array', 'homepath'));
                } else {
                    return view('errors.4032');
                }
            }
        }
        return view('DocumentLegal.index-folder', compact('directories', 'index', 'path', 'previousPath', 'array', 'homepath'));
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
        /* -------------------------------------------------------------------------- */
        /*                                Validate user                               */
        /* -------------------------------------------------------------------------- */
        $user = Auth::user();
        $idUser = $user->id;
        $isLegalUser = false;
        $users = DB::select('select * from model_has_roles where model_id = ?', [$idUser]);
        foreach ($users as $user) {
            if ($user->role_id == 7) {
                $isLegalUser = true;
                $legal = DB::select('select user_id from legals where name = ?', [$array[1]]);
                if ($idUser == $legal[0]->user_id) {
                    return view('DocumentLegal.upload-file', compact('path', 'files', 'index', 'previousPath', 'array'));
                } else {
                    return view('errors.4032');
                }
            }
        }
        return view('DocumentLegal.upload-file', compact('path', 'files', 'index', 'previousPath', 'array'));
    }
    public function uploadLegalFile(Request $request, $path)
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
            return redirect()->route('legal.index');
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
            return redirect()->route('legal.folder-list', ['path' => str_replace('/', '-', $previousPath)]);
        }
    }
    public function legalFilesList($path)
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
        if (count($array) == 2) {
            $homepath = "";
        } else {
            $homepath = explode('/', $previousPath)[0] . '/' . explode('/', $previousPath)[1];
        }
        $files = Storage::disk('s3')->files($path . '/');
        return view('DocumentLegal.file-list', compact('path', 'files', 'index', 'previousPath', 'array', 'homepath'));
    }
    public function deleteFolder($path)
    {
        $path = str_replace('-', '/', $path);
        $array = explode('/', $path);
        Storage::disk('s3')->deleteDirectory($path);
        if (count($array) == 2) {
            return redirect()->route('legal.index');
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
            return redirect()->route('legal.folder-list', ['path' => str_replace('/', '-', $previousPath)]);
        }
    }
    public function downloadLegalFile($path)
    {
        $path = str_replace('+', '/', $path);
        $pathToFile = Storage::disk('s3')->path($path);
        if (Storage::disk('s3')->exists($pathToFile)) {
            return Storage::disk('s3')->download($pathToFile);
        } else {
            return view('errors.4032');
        }
    }
    public function deleteLegalFile($path)
    {
        $path = str_replace('+', '/', $path);
        $array = explode('/', $path);
        Storage::disk('s3')->delete($path);
        if (count($array) == 2) {
            return redirect()->route('legal.fileList', ['path' => str_replace('/', '-', $path)]);
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
            $files = Storage::disk('s3')->files($path . '/');
            return redirect()->route('legal.fileList', ['path' => str_replace('/', '-', $previousPath)]);
        }
    }
}
