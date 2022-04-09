<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Report;
use App\Models\Study;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{

    public function studiesList($id)
    {
        /* -------------------------------------------------------------------------- */
        /*                                 Get user id                                */
        /* -------------------------------------------------------------------------- */
        $user = Auth::user();
        $idUser = $user->id;
        $users = DB::select('select * from model_has_roles where model_id = ?', [$idUser]);
        /* -------------------------------------------------------------------------- */
        /*                                 Get project                                */
        /* -------------------------------------------------------------------------- */
        $project = Project::find($id);
        foreach ($users as $user) {
            if ($user->role_id == 1 || $user->role_id == 2 || $user->role_id == 4 || $user->role_id == 5) {
                $projects_studies = $project->studys;
            } else if ($user->role_id == 3) {
                $projects_studies  = DB::table('users')
                    ->join('users_studies', 'users.id', '=', 'users_studies.user_id')
                    ->join('studies', 'users_studies.study_id', '=', 'studies.id')
                    ->join('projects_studies', 'studies.id', '=', 'projects_studies.study_id')
                    ->join('projects', 'projects_studies.project_id', '=', 'projects.id')
                    ->select('studies.*')
                    ->where('users.id', '=', $idUser)
                    ->where('projects.id', '=', $project->id)
                    ->get();
            }
        }
        $region_id = $project->region_id;
        return view('Report.index', compact('project', 'projects_studies', 'region_id'));
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
        /*                              Report type array                             */
        /* -------------------------------------------------------------------------- */
        $report_type = ["Bimestral", "Trimestral", "Semestral", "Anual"];
        /* -------------------------------------------------------------------------- */
        /*                                Find reports                                */
        /* -------------------------------------------------------------------------- */
        $reports = DB::select('select * from reports where project_id = ?', [(int)($studio->id . $project->id)]);
        return view('Report.index-reports', compact('project', 'studio', 'reports', 'report_type'));
    }
    public function uploadReports($id, $idStudio)
    {
        /* -------------------------------------------------------------------------- */
        /*                                 Get project and study                      */
        /* -------------------------------------------------------------------------- */
        $project = Project::find($id);
        $studio = Study::find($id);
        /* -------------------------------------------------------------------------- */
        /*                              Initial Validate                              */
        /* -------------------------------------------------------------------------- */
        if ($studio == null  || $project == null) {
            return view('errors.4032');
        }
        /* -------------------------------------------------------------------------- */
        /*                                 Get user id                                */
        /* -------------------------------------------------------------------------- */
        $user = Auth::user();
        $idUser = $user->id;
        /* -------------------------------------------------------------------------- */
        /*                                  Validate                                  */
        /* -------------------------------------------------------------------------- */
        $users = DB::select('select * from model_has_roles where model_id = ?', [$idUser]);
        /* -------------------------------------------------------------------------- */
        /*                            Find project with id                            */
        /* -------------------------------------------------------------------------- */
        foreach ($users as $user) {
            if ($user->role_id == 1 || $user->role_id == 2 || $user->role_id == 4 || $user->role_id == 5) {
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
            } else if ($user->role_id == 3) {
                $users_authorize = DB::select('select * from users_studies where user_id = ? and study_id = ?', [$idUser, $idStudio]);
                $project_study = DB::select('select * from projects_studies where projects_studies_id = ?', [(int)($id . $idStudio)]);
                if (count($project_study) == 0 || count($users_authorize) == 0) {
                    return view('errors.4032');
                } else {
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
            }
        }
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
        /* -------------------------------------------------------------------------- */
        /*                              Initial Validate                              */
        /* -------------------------------------------------------------------------- */
        $report = Report::find($id);
        $project = Project::find($idProject);
        if ($report == null  || $project == null) {
            return view('errors.4032');
        }
        $region = strtolower($project->regions->name);
        $report_type = ["Bimestral", "Trimestral", "Semestral", "Anual"];
        /* -------------------------------------------------------------------------- */
        /*                                 Get user id                                */
        /* -------------------------------------------------------------------------- */
        $user = Auth::user();
        $idUser = $user->id;
        /* -------------------------------------------------------------------------- */
        /*                                  Validate                                  */
        /* -------------------------------------------------------------------------- */
        $users = DB::select('select * from model_has_roles where model_id = ?', [$idUser]);
        foreach ($users as $user) {
            if ($user->role_id == 1 || $user->role_id == 2 || $user->role_id == 4 || $user->role_id == 5) {
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
            } else if ($user->role_id == 3) {
                $users_authorize = DB::select('select * from users_studies where user_id = ? and study_id = ?', [$idUser, $idStudio]);
                $project_study = DB::select('select * from projects_studies where projects_studies_id = ?', [(int)($idProject . $idStudio)]);
                if (count($project_study) == 0 || count($users_authorize) == 0) {
                    return view('errors.4032');
                } else {
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
        }
    }
}
