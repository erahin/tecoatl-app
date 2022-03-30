<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Report;
use App\Models\Study;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{

    public function studiesList($id)
    {
        $project = Project::find($id);
        $region_id = $project->region_id;
        return view('Report.index', compact('project', 'region_id'));
    }
    public function reportsList($id, $idStudio)
    {
        // dd($idStudio);
        /* -------------------------------------------------------------------------- */
        /*                            Find project with id                            */
        /* -------------------------------------------------------------------------- */
        $project = Project::find($id);
        /* -------------------------------------------------------------------------- */
        /*                                 Find studio                                */
        /* -------------------------------------------------------------------------- */
        $studio = Study::find($idStudio);
        /* -------------------------------------------------------------------------- */
        /*                              Report type array                             */
        /* -------------------------------------------------------------------------- */
        $report_type = ["Bimestral", "Trimestral", "Semestral", "Anual"];
        /* -------------------------------------------------------------------------- */
        /*                                Find reports                                */
        /* -------------------------------------------------------------------------- */
        // $reports = DB::table('reports')
        //     ->join('studies', 'reports.studio_id', '=', 'studies.id')
        //     ->join('projects_studies', 'studies.id', '=', 'projects_studies.study_id')
        //     ->join('projects', 'projects_studies.project_id', '=', 'projects.id')
        //     ->join('regions', 'projects.region_id', '=', 'regions.id')
        //     ->select('reports.*')
        //     ->where('projects.id', '=', $project->id)
        //     ->where('regions.id', '=', $project->region_id)
        //     ->where('studies.id', '=', $studio->id)
        //     ->get();
        // $reports = DB::table('reports', 'projects')->where('studio_id', '=', 1)->get();
        $reports = DB::select('select * from reports where studio_id = ? and project_id = ?', [$studio->id, $project->id]);
        // return $reports;
        return view('Report.index-reports', compact('project', 'studio', 'reports', 'report_type'));
    }
    public function uploadReports($id, $idStudio)
    {
        /* -------------------------------------------------------------------------- */
        /*                            Find project with id                            */
        /* -------------------------------------------------------------------------- */
        $project = Project::find($id);
        /* -------------------------------------------------------------------------- */
        /*                              Report Type Array                             */
        /* -------------------------------------------------------------------------- */
        $report_type = ["Bimestral", "Trimestral", "Semestral", "Anual"];
        /* -------------------------------------------------------------------------- */
        /*                                 Get region                                 */
        /* -------------------------------------------------------------------------- */
        $region = strtolower($project->regions->name);
        /* -------------------------------------------------------------------------- */
        /*                                Get all files                               */
        /* -------------------------------------------------------------------------- */
        $files = Storage::disk('s3')->directories('tecnico/' . $region . '/' . $id . '/' . $idStudio);
        // return $files;
        /* -------------------------------------------------------------------------- */
        /*                                Get only directory                          */
        /* -------------------------------------------------------------------------- */
        $fileDirectorie = [];
        foreach ($files as $fileNameStorage) {
            $fileArray = explode('/', $fileNameStorage);
            array_push($fileDirectorie, (int)$fileArray[4]);
        }
        /* -------------------------------------------------------------------------- */
        /*                                 Get reports                                */
        /* -------------------------------------------------------------------------- */
        $reportsArray = [];
        if ($fileDirectorie) {
            foreach ($fileDirectorie as $reports) {
                $report_find = DB::select('select concat (report_number,"° Informe ", report_type) from reports where id = ?', [$reports]);
                if ($report_find) {
                    array_push($reportsArray, $report_find[0]);
                }
            }
        }
        return view('ReportStudio.create', compact('project', 'idStudio', 'reportsArray', 'report_type'));
    }
    public function showInforms($idProject, $idStudio,  $idReport)
    {
        /* -------------------------------------------------------------------------- */
        /*                                 Return data                                */
        /* -------------------------------------------------------------------------- */
        $project = Project::find($idProject);
        $studio = Study::find($idStudio);
        $report = Report::find($idReport);
        $report_type = ["Bimestral", "Trimestral", "Semestral", "Anual"];
        /* -------------------------------------------------------------------------- */
        /*                                 Get region                                 */
        /* -------------------------------------------------------------------------- */
        $region = strtolower($project->regions->name);
        /* -------------------------------------------------------------------------- */
        /*                                Get all files                               */
        /* -------------------------------------------------------------------------- */
        $files = Storage::disk('s3')->allFiles('tecnico/' . $region . '/' . $project->id . '/' . $idStudio . '/' . $idReport . '/');
        // /* -------------------------------------------------------------------------- */
        // /*                                Get file url                                */
        // /* -------------------------------------------------------------------------- */
        // if ($files) {
        //     $urls = [];
        //     foreach ($files as $file) {
        //         $url = Storage::url($file);
        //         array_push($urls, $url);
        //     }
        // }
        /* -------------------------------------------------------------------------- */
        /*                            Return view and data                            */
        /* -------------------------------------------------------------------------- */
        return view(
            'Report.show',
            compact('project', 'studio', 'files', 'report', 'report_type')
        );
    }
    public function downloadFile($idProject, $idStudio,  $idReport, $nameFile)
    {
        $project = Project::find($idProject);
        $region = strtolower($project->regions->name);
        $pathToFile = Storage::disk('s3')->path('tecnico/' . $region . '/' . $idProject . '/' . $idStudio . '/' . $idReport . '/' . $nameFile);
        return Storage::disk('s3')->download($pathToFile);
    }
    public function deleteFile($idProject, $idStudio,  $idReport, $nameFile)
    {
        $project = Project::find($idProject);
        $region = strtolower($project->regions->name);
        Storage::disk('s3')->delete('tecnico/' . $region . '/' . $idProject . '/' . $idStudio . '/' . $idReport . '/' . $nameFile);
        return redirect()->route('show-informs', [$idProject, $idStudio, $idReport]);
    }
    public function deleteStudioDirectory($idProject, $idStudio)
    {
        $project = Project::find($idProject);
        $region = strtolower($project->regions->name);
        $project->studys()->detach($idStudio);
        Storage::disk('s3')->deleteDirectory('tecnico/' . $region . '/' . $idProject . '/' . $idStudio . '/');
        return redirect()->route('studies-list', [$idProject, $idStudio]);
    }
    public function deleteReportsDirectory($idProject, $idStudio,  $idReport)
    {
        $project = Project::find($idProject);
        $region = strtolower($project->regions->name);
        Storage::disk('s3')->deleteDirectory('tecnico/' . $region . '/' . $idProject . '/' . $idStudio . '/' . $idReport . '/');
        $report = Report::find($idReport);
        $report->delete();
        return redirect()->route('reports-list', [$idProject, $idStudio]);
    }
    public function reportEdit($id, $idStudio, $idProject)
    {
        $report = Report::find($id);
        $project = Project::find($idProject);
        $region = strtolower($project->regions->name);
        $report_type = ["Bimestral", "Trimestral", "Semestral", "Anual"];
        $allfiles = Storage::disk('s3')->allFiles('tecnico/' . $region . '/' . $idProject . '/' . $idStudio . '/' . $id . '/');
        /* -------------------------------------------------------------------------- */
        /*                                Get file url                                */
        /* -------------------------------------------------------------------------- */
        $files = [];
        foreach ($allfiles as $file) {
            $url = Storage::url($file);
            array_push($files, $url);
        }
        return view('ReportStudio.edit', compact('report', 'files', 'project', 'idStudio', 'report_type'));
    }
}
