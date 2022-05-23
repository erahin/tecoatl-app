<?php

namespace App\Http\Controllers;

use App\Models\Administrative;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;

class DocumentAdministrativeController extends Controller
{

    public function createFolder($idAdministrative)
    {
        /* -------------------------------------------------------------------------- */
        /*                                  Validate                                  */
        /* -------------------------------------------------------------------------- */
        $administrative = Administrative::find($idAdministrative);
        if ($administrative == null) {
            return view('errors.4032');
        }
        if ($administrative->id === 1) {
            // foreach ($directories as $directorie) {
            //     $project = Project::find(explode('/', $directorie)[2]);
            //     if ($project != null) {
            //         array_push($projects, $project->place);
            //     }
            // }
            return view('errors.4032');
        }
        /* -------------------------------------------------------------------------- */
        /*                                  Get data                                  */
        /* -------------------------------------------------------------------------- */
        $directories = Storage::disk('s3')->directories('administrativo/' . $idAdministrative . '/');
        $projects = [];
        /* -------------------------------------------------------------------------- */
        /*                                 Get user                                   */
        /* -------------------------------------------------------------------------- */
        $user = Auth::user();
        $idUser = $user->id;
        $user = $user->roles[0]->name;
        if ($user != "Jefa subadministrativa") {
            return view('DocumentAdministrative.create', compact('idAdministrative', 'administrative', 'directories'));
        }
        if ($user == "Jefa subadministrativa" && $administrative->user_id == $idUser) {
            return view('DocumentAdministrative.create', compact('idAdministrative', 'administrative', 'directories'));
        } else {
            return view('errors.4032');
        }
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
        /* -------------------------------------------------------------------------- */
        /*                                  Validate                                  */
        /* -------------------------------------------------------------------------- */
        $administrative = Administrative::find($idAdministrative);
        if ($administrative == null) {
            return view('errors.4032');
        }
        /* -------------------------------------------------------------------------- */
        /*                                 Get user                                   */
        /* -------------------------------------------------------------------------- */
        $user = Auth::user();
        $idUser = $user->id;
        $user = $user->roles[0]->name;
        /* -------------------------------------------------------------------------- */
        /*                                  Get data                                  */
        /* -------------------------------------------------------------------------- */
        $directories = Storage::disk('s3')->directories('administrativo/' . $idAdministrative . '/');
        $folderArray = [];
        $idArray = [];
        foreach ($directories as $directorie) {
            array_push($folderArray, $directorie);
            if ($administrative->id === 1) {
                array_push($idArray, explode('/', $directorie)[2]);
            }
        }
        $projectArray = [];
        if ($administrative->id === 1) {
            foreach ($idArray as $id) {
                $project = Project::find($id);
                if ($project != null) {
                    array_push($projectArray, $project);
                }
            }
        }
        /* -------------------------------------------------------------------------- */
        /*                                  Validate user                             */
        /* -------------------------------------------------------------------------- */
        if ($user != "Jefa subadministrativa") {
            return view('DocumentAdministrative.index-folder', compact('idAdministrative', 'administrative', 'directories', 'projectArray', 'folderArray'));
        }
        if ($user == "Jefa subadministrativa" && $administrative->user_id == $idUser) {
            return view('DocumentAdministrative.index-folder', compact('idAdministrative', 'administrative', 'directories', 'projectArray', 'folderArray'));
        } else {
            return view('errors.4032');
        }
    }
    public function showFormUploadFile($idAdministrative, $folder)
    {
        /* -------------------------------------------------------------------------- */
        /*                                  Validate                                  */
        /* -------------------------------------------------------------------------- */
        $administrative = Administrative::find($idAdministrative);
        $directories = Storage::disk('s3')->directories('administrativo/' . $idAdministrative . '/');
        $isDirectorie = false;
        for ($i = 0; $i < count($directories); $i++) {
            if (explode('/', $directories[$i])[2] == $folder) {
                $isDirectorie = true;
                break;
            }
        }
        if ($administrative == null || $isDirectorie == false) {
            return view('errors.4032');
        }
        /* -------------------------------------------------------------------------- */
        /*                                 Get user                                   */
        /* -------------------------------------------------------------------------- */
        $user = Auth::user();
        $idUser = $user->id;
        $user = $user->roles[0]->name;
        /* -------------------------------------------------------------------------- */
        /*                                Get all files                               */
        /* -------------------------------------------------------------------------- */
        $files = Storage::disk('s3')->files('administrativo/' . $idAdministrative . '/' . $folder . '/');
        $project = null;
        if ($administrative->id === 1) {
            $project = Project::find($folder);
        }
        /* -------------------------------------------------------------------------- */
        /*                                  Validate user                             */
        /* -------------------------------------------------------------------------- */
        if ($user != "Jefa subadministrativa") {
            return view('DocumentAdministrative.upload-file', compact('idAdministrative', 'administrative', 'files', 'folder', 'directories', 'project'));
        }
        if ($user == "Jefa subadministrativa" && $administrative->user_id == $idUser) {
            return view('DocumentAdministrative.upload-file', compact('idAdministrative', 'administrative', 'files', 'folder', 'directories', 'project'));
        } else {
            return view('errors.4032');
        }
    }
    public function uploadFile(Request $request, $idAdministrative, $folder)
    {
        $administrative = Administrative::find($idAdministrative);
        if ($administrative == null) {
            return view('errors.4032');
        }
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
            $pathToFile = 'administrativo/' . $idAdministrative . '/' . $folder;
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
    public function fileList($idAdministrative, $folder)
    {
        $administrative = Administrative::find($idAdministrative);
        if ($administrative == null) {
            return view('errors.4032');
        }
        /* -------------------------------------------------------------------------- */
        /*                                 Get user                                   */
        /* -------------------------------------------------------------------------- */
        $user = Auth::user();
        $idUser = $user->id;
        $user = $user->roles[0]->name;
        /* -------------------------------------------------------------------------- */
        /*                                Get data                                    */
        /* -------------------------------------------------------------------------- */
        $project = null;
        if ($administrative->id === 1) {
            $project = Project::find($folder);
        }
        $files = Storage::disk('s3')->files('administrativo/' . $idAdministrative . '/' . $folder . '/');
        /* -------------------------------------------------------------------------- */
        /*                                  Validate user                             */
        /* -------------------------------------------------------------------------- */
        if ($user != "Jefa subadministrativa") {
            return view('DocumentAdministrative.file-list', compact('idAdministrative', 'administrative', 'project', 'files'));
        }
        if ($user == "Jefa subadministrativa" && $administrative->user_id == $idUser) {
            return view('DocumentAdministrative.file-list', compact('idAdministrative', 'administrative', 'project', 'files'));
        } else {
            return view('errors.4032');
        }
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
        if (Storage::disk('s3')->exists($pathToFile)) {
            return Storage::disk('s3')->download($pathToFile);
        } else {
            return view('errors.4032');
        }
    }
    public function createSubFolder($idAdministrative, $folder)
    {
        /* -------------------------------------------------------------------------- */
        /*                                  Validate                                  */
        /* -------------------------------------------------------------------------- */
        $administrative = Administrative::find($idAdministrative);
        $directories = Storage::disk('s3')->directories('administrativo/' . $idAdministrative . '/');
        $isDirectorie = false;
        for ($i = 0; $i < count($directories); $i++) {
            if (explode('/', $directories[$i])[2] == $folder) {
                $isDirectorie = true;
                break;
            }
        }
        $administrative = Administrative::find($idAdministrative);
        if ($administrative == null || $isDirectorie == false) {
            return view('errors.4032');
        }
        /* -------------------------------------------------------------------------- */
        /*                                 Get user                                   */
        /* -------------------------------------------------------------------------- */
        $user = Auth::user();
        $idUser = $user->id;
        $user = $user->roles[0]->name;
        /* -------------------------------------------------------------------------- */
        /*                                Get data                                    */
        /* -------------------------------------------------------------------------- */
        $directories = Storage::disk('s3')->directories('administrativo/' . $idAdministrative . '/' . $folder . '/');
        $project = null;
        if ($administrative->id === 1) {
            $project = Project::find($folder);
        }
        /* -------------------------------------------------------------------------- */
        /*                                  Validate user                             */
        /* -------------------------------------------------------------------------- */
        if ($user != "Jefa subadministrativa") {
            return view('DocumentAdministrative.create-subfolder', compact('idAdministrative', 'administrative', 'directories', 'project', 'folder'));
        }
        if ($user == "Jefa subadministrativa" && $administrative->user_id == $idUser) {
            return view('DocumentAdministrative.create-subfolder', compact('idAdministrative', 'administrative', 'directories', 'project', 'folder'));
        } else {
            return view('errors.4032');
        }
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
        /* -------------------------------------------------------------------------- */
        /*                                  Validate                                  */
        /* -------------------------------------------------------------------------- */
        $administrative = Administrative::find($idAdministrative);
        if ($administrative == null) {
            return view('errors.4032');
        }
        /* -------------------------------------------------------------------------- */
        /*                                 Get user                                   */
        /* -------------------------------------------------------------------------- */
        $user = Auth::user();
        $idUser = $user->id;
        $user = $user->roles[0]->name;
        /* -------------------------------------------------------------------------- */
        /*                               Get data                                     */
        /* -------------------------------------------------------------------------- */
        $directories = Storage::disk('s3')->directories('administrativo/' . $idAdministrative . '/' . $folder . '/');
        $folderArray = [];
        foreach ($directories as $directorie) {
            array_push($folderArray, $directorie);
        }
        $project = null;
        if ($administrative->id === 1) {
            $project = Project::find($folder);
        }
        /* -------------------------------------------------------------------------- */
        /*                                  Validate user                             */
        /* -------------------------------------------------------------------------- */
        if ($user != "Jefa subadministrativa") {
            return view('DocumentAdministrative.index-subfolder', compact('idAdministrative', 'administrative', 'directories', 'project', 'folderArray'));
        }
        if ($user == "Jefa subadministrativa" && $administrative->user_id == $idUser) {
            return view('DocumentAdministrative.index-subfolder', compact('idAdministrative', 'administrative', 'directories', 'project', 'folderArray'));
        } else {
            return view('errors.4032');
        }
    }
    public function showFormUploadFileSubFolder($idAdministrative, $folder, $subfolder)
    {
        /* -------------------------------------------------------------------------- */
        /*                                  Validate                                  */
        /* -------------------------------------------------------------------------- */
        $administrative = Administrative::find($idAdministrative);
        $directories = Storage::disk('s3')->directories('administrativo/' . $idAdministrative . '/' . $folder . '/');
        $isDirectorie = false;
        for ($i = 0; $i < count($directories); $i++) {
            if (explode('/', $directories[$i])[3] == $subfolder) {
                $isDirectorie = true;
                break;
            }
        }
        $administrative = Administrative::find($idAdministrative);
        if ($administrative == null || $isDirectorie == false) {
            return view('errors.4032');
        }
        /* -------------------------------------------------------------------------- */
        /*                                Get data                                    */
        /* -------------------------------------------------------------------------- */
        $files = Storage::disk('s3')->files('administrativo/' . $idAdministrative . '/' . $folder . '/' . $subfolder . '/');
        $project = null;
        if ($administrative->id === 1) {
            $project = Project::find($folder);
        }
        /* -------------------------------------------------------------------------- */
        /*                                 Get user                                   */
        /* -------------------------------------------------------------------------- */
        $user = Auth::user();
        $idUser = $user->id;
        $user = $user->roles[0]->name;
        /* -------------------------------------------------------------------------- */
        /*                                  Validate user                             */
        /* -------------------------------------------------------------------------- */
        if ($user != "Jefa subadministrativa") {
            return view('DocumentAdministrative.upload-file-subfolder', compact('idAdministrative', 'administrative', 'files', 'project', 'folder', 'subfolder'));
        }
        if ($user == "Jefa subadministrativa" && $administrative->user_id == $idUser) {
            return view('DocumentAdministrative.upload-file-subfolder', compact('idAdministrative', 'administrative', 'files', 'project', 'folder', 'subfolder'));
        } else {
            return view('errors.4032');
        }
    }
    public function uploadFileSubFolder(Request $request, $idAdministrative, $folder, $subfolder)
    {
        $administrative = Administrative::find($idAdministrative);
        if ($administrative == null) {
            return view('errors.4032');
        }
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
            $filePath = 'administrativo/' . $idAdministrative . '/' . $folder . '/' . $subfolder;
            $path = Storage::disk('s3')->putFileAs($filePath, $file, $fileName);
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
    public function subFolderFileList($idAdministrative, $folder, $subfolder)
    {
        /* -------------------------------------------------------------------------- */
        /*                                  Validate                                  */
        /* -------------------------------------------------------------------------- */
        $administrative = Administrative::find($idAdministrative);
        if ($administrative == null) {
            return view('errors.4032');
        }
        /* -------------------------------------------------------------------------- */
        /*                                 Get user                                   */
        /* -------------------------------------------------------------------------- */
        $user = Auth::user();
        $idUser = $user->id;
        $user = $user->roles[0]->name;
        /* -------------------------------------------------------------------------- */
        /*                               Get data                                     */
        /* -------------------------------------------------------------------------- */
        $files = Storage::disk('s3')->files('administrativo/' . $idAdministrative . '/' . $folder . '/' . $subfolder . '/');
        $project = null;
        if ($administrative->id === 1) {
            $project = Project::find($folder);
        }
        /* -------------------------------------------------------------------------- */
        /*                                  Validate user                             */
        /* -------------------------------------------------------------------------- */
        if ($user != "Jefa subadministrativa") {
            return view('DocumentAdministrative.file-list-subfolder', compact('idAdministrative', 'administrative', 'files', 'folder', 'subfolder', 'project'));
        }
        if ($user == "Jefa subadministrativa" && $administrative->user_id == $idUser) {
            return view('DocumentAdministrative.file-list-subfolder', compact('idAdministrative', 'administrative', 'files', 'folder', 'subfolder', 'project'));
        } else {
            return view('errors.4032');
        }
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
        if (Storage::disk('s3')->exists($pathToFile)) {
            return Storage::disk('s3')->download($pathToFile);
        } else {
            return view('errors.4032');
        }
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
