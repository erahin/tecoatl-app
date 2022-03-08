<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Region;
use App\Models\Report;
use App\Models\Study;
use AWS\CRT\HTTP\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Filesystem;
use stdClass;

class ReportController extends Controller
{
    public function studiesList($id) //ok
    {
        $project = Project::find($id);
        return view('Report.index', compact('project'));
    }
    public function reportsList($id, $idStudio)
    {
        /* -------------------------------------------------------------------------- */
        /*                            Find project with id                            */
        /* -------------------------------------------------------------------------- */
        $project = Project::find($id);
        /* -------------------------------------------------------------------------- */
        /*                                 Find studio                                */
        /* -------------------------------------------------------------------------- */
        $studio = Study::find($idStudio);
        /* -------------------------------------------------------------------------- */
        /*                                Find reports                                */
        /* -------------------------------------------------------------------------- */
        $reports =  DB::select('select * from reports where project_id = ? and studio_id = ?', [$id, $idStudio]);
        /* -------------------------------------------------------------------------- */
        /*                                 Get region                                 */
        /* -------------------------------------------------------------------------- */
        $region = strtolower($project->regions->name);
        /* -------------------------------------------------------------------------- */
        /*                                Get all files                               */
        /* -------------------------------------------------------------------------- */
        // $files = Storage::disk('s3')->allFiles('tecnico/' . $region . '/' . $id . '/' . $idStudio . '/');
        // /* -------------------------------------------------------------------------- */
        // /*                                Get only name                               */
        // /* -------------------------------------------------------------------------- */
        // $fileName = [];
        // foreach ($files as $fileNameStorage) {
        //     $fileArray = explode('/', $fileNameStorage);
        //     array_push($fileName, $fileArray[4]);
        // }
        return view('Report.index-reports', compact('project', 'studio', 'reports'));
    }
    public function uploadReports($id, $idStudio)
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
        $files = Storage::disk('s3')->directories('tecnico/' . $region . '/' . $id . '/' . $idStudio);
        /* -------------------------------------------------------------------------- */
        /*                                Get only directory                          */
        /* -------------------------------------------------------------------------- */
        $fileDirectorie = [];
        foreach ($files as $fileNameStorage) {
            $fileArray = explode('/', $fileNameStorage);
            array_push($fileDirectorie, (int)$fileArray[4]);
        }
        $reportsArray = [];
        if ($fileDirectorie) {
            foreach ($fileDirectorie as $reports) {
                $report_find = DB::select('select report_number from reports where id = ?', [$reports]);
                if ($report_find) {
                    array_push($reportsArray, $report_find[0]);
                }
                break;
            }
        }
        // return $reportsArray;
        // $nameReport = [];
        // foreach ($files as $fileNameStorage) {
        //     $fileArray = explode('/', $fileNameStorage);
        //     array_push($nameReport, $fileArray[5]);
        // }
        return view('ReportStudio.create', compact('project', 'idStudio', 'reportsArray'));
    }
    public function showInforms($idProject, $idStudio,  $idReport)
    {
        /* -------------------------------------------------------------------------- */
        /*                                 Return data                                */
        /* -------------------------------------------------------------------------- */
        $project = Project::find($idProject);
        $studio = Study::find($idStudio);
        $report = Report::find($idReport);
        /* -------------------------------------------------------------------------- */
        /*                                 Get region                                 */
        /* -------------------------------------------------------------------------- */
        $region = strtolower($project->regions->name);
        /* -------------------------------------------------------------------------- */
        /*                                Get all files                               */
        /* -------------------------------------------------------------------------- */
        $files = Storage::disk('s3')->allFiles('tecnico/' . $region . '/' . $project->id . '/' . $idStudio . '/' . $idReport . '/');
        /* -------------------------------------------------------------------------- */
        /*                                Get file url                                */
        /* -------------------------------------------------------------------------- */
        $urls = [];
        foreach ($files as $file) {
            $url = Storage::url($file);
            array_push($urls, $url);
        }
        /* -------------------------------------------------------------------------- */
        /*                            Return view and data                            */
        /* -------------------------------------------------------------------------- */
        return view(
            'Report.show',
            compact('project', 'studio', 'urls', 'files', 'report')
        );
    }
    public function downloadFile($idProject, $idStudio,  $idReport, $nameFile)
    {
        // $file = Storage::disk('s3')->get($file_path);
        // return Storage::url($file_path);
        $project = Project::find($idProject);
        $region = strtolower($project->regions->name);
        $pathToFile = Storage::disk('s3')->get('tecnico/' . $region . '/' . $idProject . '/' . $idStudio . '/' . $idReport . '/' . $nameFile);
        $headers = ['Content-Type: application/pdf'];
        // return response()->download($pathToFile, $nameFile, $headers);
        return Storage::download($pathToFile, $nameFile, $headers);
    }
    public function deleteFile($idProject, $idStudio,  $idReport, $nameFile)
    {
        $project = Project::find($idProject);
        $region = strtolower($project->regions->name);
        Storage::disk('s3')->delete('tecnico/' . $region . '/' . $idProject . '/' . $idStudio . '/' . $idReport . '/' . $nameFile);
        return redirect()->route('show-informs', [$idProject, $idStudio, $idReport]);
    }
}
