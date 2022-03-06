<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    public function create($id)
    {
        $project = Project::find($id);
        return view('Report.index', compact('project'));
    }
    public function createReport($id, $idStudio)
    {
        /* -------------------------------------------------------------------------- */
        /*                            Find project with id                            */
        /* -------------------------------------------------------------------------- */
        $project = Project::find($id);
        /* -------------------------------------------------------------------------- */
        /*                                 Get region                                 */
        /* -------------------------------------------------------------------------- */
        $region = strtolower($project->regions->name);
        /* -------------------------------------------------------------------------- */
        /*                                Get all files                               */
        /* -------------------------------------------------------------------------- */
        $files = Storage::disk('s3')->allFiles('tecnico/' . $region . '/' . $id . '/' . $idStudio . '/');
        /* -------------------------------------------------------------------------- */
        /*                                Get only name                               */
        /* -------------------------------------------------------------------------- */
        $fileName = [];
        foreach ($files as $fileNameStorage) {
            $fileArray = explode('/', $fileNameStorage);
            array_push($fileName, $fileArray[4]);
        }
        $project = Project::find($id);
        return view('ReportStudio.create', compact('project', 'idStudio', 'fileName'));
    }
}
