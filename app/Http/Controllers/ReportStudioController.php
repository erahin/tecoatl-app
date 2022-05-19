<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Report;
use App\Models\Study;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ReportStudioController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:informes.create')->only('create', 'store');
    }
    public function store(Request $request)
    {
        /* -------------------------------------------------------------------------- */
        /*                                  Validate                                  */
        /* -------------------------------------------------------------------------- */
        $request->validate([
            'report_number' => ['required', 'integer'],
            'name' => ['required', 'unique:reports', 'string'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
            'report_type' => ['required', 'integer'],
            // 'reports' => ['required']
        ]);
        /* -------------------------------------------------------------------------- */
        /*                            Find project with id                            */
        /* -------------------------------------------------------------------------- */
        $project = Project::find($request->project_id);
        /* -------------------------------------------------------------------------- */
        /*                            Find study with id                              */
        /* -------------------------------------------------------------------------- */
        $study = Study::find($request->studio_id);
        /* -------------------------------------------------------------------------- */
        /*                              Initial Validate                              */
        /* -------------------------------------------------------------------------- */
        if ($project == null || $study == null) {
            return view('errors.4032');
        }
        /* -------------------------------------------------------------------------- */
        /*                                 Get user id                                */
        /* -------------------------------------------------------------------------- */
        $user = Auth::user();
        $idUser = $user->id;
        /* -------------------------------------------------------------------------- */
        /*                                Create report                               */
        /* -------------------------------------------------------------------------- */
        $report = new Report();
        $report->report_number = $request->report_number;
        $report->name = $request->name;
        $report->start_date = $request->start_date;
        $report->end_date = $request->end_date;
        $report->report_type = $request->report_type;
        /* -------------------------------------------------------------------------- */
        /*                           Get project_studies_id                           */
        /* -------------------------------------------------------------------------- */
        $projects_studies_id = DB::select(
            'select * from projects_studies where study_id = ? and project_id = ? limit 1',
            [$study->id, $project->id]
        );
        /* -------------------------------------------------------------------------- */
        /*                                 Get region                                 */
        /* -------------------------------------------------------------------------- */
        $region = strtolower($project->regions->name);

        $report->project_id = $projects_studies_id[0]->projects_studies_id;
        $report->studio_id = $study->id;
        $report->user_id = $idUser;
        $report->save();
        $report = Report::latest('id')->first();
        // /* -------------------------------------------------------------------------- */
        // /*                          Insert files to directory                         */
        // /* -------------------------------------------------------------------------- */
        // foreach ($request->file('reports') as $fileRequest) {
        //     set_time_limit(0);
        //     $file = $fileRequest;
        //     $fileName = $fileRequest->getClientOriginalName();
        //     $filePath = 'tecnico/' . $region . '/' . $project->id . '/' . $study->id . '/' . $report->id;
        //     Storage::disk('s3')->putFileAs($filePath, $file, $fileName);
        // }
        /* -------------------------------------------------------------------------- */
        /*                                 Redirect to                                */
        /* -------------------------------------------------------------------------- */
        return redirect()->route('studies-list', $project->id);
    }

    public function update(Request $request, $id)
    {
        /* -------------------------------------------------------------------------- */
        /*                                  Validate                                  */
        // /* -------------------------------------------------------------------------- */
        $request->validate([
            'report_number' => ['required', 'integer'],
            'name' => ['required', 'string'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
            'report_type' => ['required', 'integer'],
            // 'reports' => ['required']
        ]);
        /* -------------------------------------------------------------------------- */
        /*                                Create report                               */
        /* -------------------------------------------------------------------------- */
        $report = Report::find($id);
        /* -------------------------------------------------------------------------- */
        /*                            Find project with id                            */
        /* -------------------------------------------------------------------------- */
        $project = Project::find($request->project_id);
        /* -------------------------------------------------------------------------- */
        /*                            Find study with id                              */
        /* -------------------------------------------------------------------------- */
        $study = Study::find($request->studio_id);
        /* -------------------------------------------------------------------------- */
        /*                              Initial Validate                              */
        /* -------------------------------------------------------------------------- */
        if ($report == null || $project == null || $study == null) {
            return view('errors.4032');
        }
        /* -------------------------------------------------------------------------- */
        /*                                 Get user id                                */
        /* -------------------------------------------------------------------------- */
        $user = Auth::user();
        $idUser = $user->id;
        $report->report_number = $request->report_number;
        $report->name = $request->name;
        $report->start_date = $request->start_date;
        $report->end_date = $request->end_date;
        $report->report_type = $request->report_type;
        $projects_studies_id = DB::select(
            'select * from projects_studies where study_id = ? and project_id = ? limit 1',
            [$study->id, $project->id]
        );
        $report->project_id = $projects_studies_id[0]->projects_studies_id;
        $report->studio_id = $study->id;
        $report->user_id = $idUser;
        $report->save();
        /* -------------------------------------------------------------------------- */
        /*                                 Get region                                 */
        /* -------------------------------------------------------------------------- */
        $region = strtolower($project->regions->name);
        /* -------------------------------------------------------------------------- */
        /*                          Insert files to directory                         */
        /* -------------------------------------------------------------------------- */
        // foreach ($request->file('reports') as $fileRequest) {
        //     set_time_limit(0);
        //     $file = $fileRequest;
        //     $fileName = $fileRequest->getClientOriginalName();
        //     $filePath = 'tecnico/' . $region . '/' . $project->id . '/' . $study->id . '/' . $id;
        //     Storage::disk('s3')->putFileAs($filePath, $file, $fileName);
        // }
        /* -------------------------------------------------------------------------- */
        /*                                 Redirect to                                */
        /* -------------------------------------------------------------------------- */
        return redirect()->route('reports-list', [$project->id, $study->id]);
    }
}
