<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Report;
use App\Models\Study;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;

class ReportController extends Controller
{

    public function studiesList($id)
    {
        /* -------------------------------------------------------------------------- */
        /*                                 Get project                                */
        /* -------------------------------------------------------------------------- */
        $project = Project::find($id);
        /* -------------------------------------------------------------------------- */
        /*                              Initial Validate                              */
        /* -------------------------------------------------------------------------- */
        if ($project == null) {
            return view('errors.4032');
        }
        /* -------------------------------------------------------------------------- */
        /*                                 Get user id                                */
        /* -------------------------------------------------------------------------- */
        $user = Auth::user();
        $idUser = $user->id;
        $users = DB::select('select * from model_has_roles where model_id = ?', [$idUser]);
        $projects_studies = $project->studys;
        foreach ($users as $user) {
            if ($user->role_id == 3) {
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
            if ($user->role_id == 3) {
                $users_authorize = DB::select(
                    'select * from users_studies where user_id = ? and study_id = ?',
                    [$idUser, $idStudio]
                );
                $project_study = DB::select('select * from projects_studies where projects_studies_id = ?', [(int)($id . $idStudio)]);
                if (count($project_study) == 0 || count($users_authorize) == 0) {
                    return view('errors.4032');
                }
            }
        }
        /* -------------------------------------------------------------------------- */
        /*                              Report type array                             */
        /* -------------------------------------------------------------------------- */
        $report_type = ["Bimestral", "Trimestral", "Semestral", "Anual"];
        /* -------------------------------------------------------------------------- */
        /*                                Find reports                                */
        /* -------------------------------------------------------------------------- */
        $reports = DB::select('select * from reports where project_id = ?', [(int)($project->id . $studio->id)]);
        return view('Report.index-reports', compact(
            'project',
            'studio',
            'reports',
            'report_type'
        ));
    }
    public function uploadReports($id, $idStudio)
    {
        /* -------------------------------------------------------------------------- */
        /*                                 Get project and study                      */
        /* -------------------------------------------------------------------------- */
        $project = Project::find($id);
        $studio = Study::find($idStudio);
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
            if ($user->role_id == 3) {
                $users_authorize = DB::select(
                    'select * from users_studies where user_id = ? and study_id = ?',
                    [$idUser, $idStudio]
                );
                $project_study = DB::select('select * from projects_studies where projects_studies_id = ?', [(int)($id . $idStudio)]);
                if (count($project_study) == 0 || count($users_authorize) == 0) {
                    return view('errors.4032');
                }
            }
        }
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
        $reports = DB::select('select * from reports where project_id = ?',  [$id . $idStudio]);
        return view('ReportStudio.create', compact(
            'project',
            'studio',
            'reports',
            'report_type'
        ));
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
        /*                              Initial Validate                              */
        /* -------------------------------------------------------------------------- */
        if ($report == null  || $project == null || $report == null) {
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
            if ($user->role_id == 3) {
                $users_authorize = DB::select('select * from users_studies where user_id = ? and study_id = ?', [$idUser, $idStudio]);
                $project_study = DB::select('select * from projects_studies where projects_studies_id = ?', [(int)($idProject . $idStudio)]);
                if (count($project_study) == 0 || count($users_authorize) == 0) {
                    return view('errors.4032');
                }
            }
        }
        $report_type = ["Bimestral", "Trimestral", "Semestral", "Anual"];
        /* -------------------------------------------------------------------------- */
        /*                                 Get region                                 */
        /* -------------------------------------------------------------------------- */
        $region = strtolower($project->regions->name);
        /* -------------------------------------------------------------------------- */
        /*                                Get all files                               */
        /* -------------------------------------------------------------------------- */
        $files = Storage::disk('s3')->allFiles('Tecnico/' . $region . '/' . $project->id . '/' . $idStudio . '/' . $idReport . '/');
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
        $pathToFile = Storage::disk('s3')->path('Tecnico/' . $region . '/' . $idProject . '/' . $idStudio . '/' . $idReport . '/' . $nameFile);
        if (Storage::disk('s3')->exists($pathToFile)) {
            return Storage::disk('s3')->download($pathToFile);
        } else {
            return view('errors.4032');
        }
    }
    public function deleteFile($idProject, $idStudio,  $idReport, $nameFile)
    {
        $project = Project::find($idProject);
        $region = strtolower($project->regions->name);
        Storage::disk('s3')->delete('Tecnico/' . $region . '/' . $idProject . '/' . $idStudio . '/' . $idReport . '/' . $nameFile);
        return redirect()->route('show-informs', [$idProject, $idStudio, $idReport]);
    }
    public function deleteStudioDirectory($idProject, $idStudio)
    {
        $project = Project::find($idProject);
        $region = strtolower($project->regions->name);
        $project->studys()->detach($idStudio);
        Storage::disk('s3')->deleteDirectory('Tecnico/' . $region . '/' . $idProject . '/' . $idStudio . '/');
        return redirect()->route('studies-list', [$idProject, $idStudio]);
    }
    public function deleteReportsDirectory($idProject, $idStudio,  $idReport)
    {
        $project = Project::find($idProject);
        $region = strtolower($project->regions->name);
        Storage::disk('s3')->deleteDirectory('Tecnico/' . $region . '/' . $idProject . '/' . $idStudio . '/' . $idReport . '/');
        $report = Report::find($idReport);
        $report->delete();
        return redirect()->route('reports-list', [$idProject, $idStudio]);
    }
    public function reportEdit($id, $idStudio, $idProject)
    {
        $report = Report::find($id);
        $project = Project::find($idProject);
        $studio = Study::find($idStudio);
        /* -------------------------------------------------------------------------- */
        /*                              Initial Validate                              */
        /* -------------------------------------------------------------------------- */
        if ($report == null  || $project == null || $studio == null) {
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
        /* -------------------------------------------------------------------------- */
        /*                            Find project with id                            */
        /* -------------------------------------------------------------------------- */
        foreach ($users as $user) {
            if ($user->role_id == 3) {
                $users_authorize = DB::select('select * from users_studies where user_id = ? and study_id = ?', [$idUser, $idStudio]);
                $project_study = DB::select('select * from projects_studies where projects_studies_id = ?', [(int)($idProject . $idStudio)]);
                if (count($project_study) == 0 || count($users_authorize) == 0) {
                    return view('errors.4032');
                }
            }
        }
        return view('ReportStudio.edit', compact('report', 'project', 'studio', 'report_type'));
    }
    public function reportWithUser()
    {
        $report_type = ["Bimestral", "Trimestral", "Semestral", "Anual"];
        $reportArray = DB::table('reports')
            ->join('users', 'reports.user_id', '=', 'users.id')
            ->select('reports.*', 'users.name as user')
            ->get();
        return view('Report.report-query', compact('reportArray', 'report_type'));
    }
    public function uploadFormFile($idReport, $idStudio, $idProject)
    {
        $report = Report::find($idReport);
        $project = Project::find($idProject);
        $studio = Study::find($idStudio);
        /* -------------------------------------------------------------------------- */
        /*                              Initial Validate                              */
        /* -------------------------------------------------------------------------- */
        if ($report == null  || $project == null) {
            return view('errors.4032');
        }
        $region = strtolower($project->regions->name);
        /* -------------------------------------------------------------------------- */
        /*                                Get file url                                */
        /* -------------------------------------------------------------------------- */
        $files = Storage::disk('s3')->files('Tecnico/' . $region . '/' . $idProject . '/' . $idStudio . '/' . $idReport . '/');
        $report_type = ["Bimestral", "Trimestral", "Semestral", "Anual"];
        return view('Report.upload-file', compact('project', 'studio', 'report', 'files', 'report_type'));
    }
    public function uploadFileReport(Request $request, $idReport, $idStudio, $idProject)
    {
        $project = Project::find($idProject);
        $region = strtolower($project->regions->name);
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
            $pathToFile = 'Tecnico/' . $region . '/' . $idProject . '/' . $idStudio . '/' . $idReport;
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
}
