<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Report;
use Illuminate\Http\Request;
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
        // /* -------------------------------------------------------------------------- */
        $request->validate([
            'report_number' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'report_type' => 'required',
            'reports' => 'required'
        ]);
        /* -------------------------------------------------------------------------- */
        /*                                Create report                               */
        /* -------------------------------------------------------------------------- */
        $report = new Report();
        $report->report_number = $request->report_number;
        $report->start_date = $request->start_date;
        $report->end_date = $request->end_date;
        $report->report_type = $request->report_type;
        $report->project_id = $request->project_id;
        $report->studio_id = $request->studio_id;
        $report->user_id = $request->user_id;
        $report->save();
        $report = Report::latest('id')->first();
        /* -------------------------------------------------------------------------- */
        /*                            Find project with id                            */
        /* -------------------------------------------------------------------------- */
        $project = Project::find($request->project_id);
        /* -------------------------------------------------------------------------- */
        /*                                 Get region                                 */
        /* -------------------------------------------------------------------------- */
        $region = strtolower($project->regions->name);
        /* -------------------------------------------------------------------------- */
        /*                          Insert files to directory                         */
        /* -------------------------------------------------------------------------- */
        foreach ($request->file('reports') as $fileRequest) {
            $file = $fileRequest;
            $fileName = $fileRequest->getClientOriginalName();
            $filePath = 'tecnico/' . $region . '/' . $project->id . '/' . $request->studio_id . '/' . $report->id . '/' . $fileName;
            Storage::disk('s3')->put($filePath, file_get_contents($file));
        }
        /* -------------------------------------------------------------------------- */
        /*                                 Redirect to                                */
        /* -------------------------------------------------------------------------- */
        return redirect()->route('studies-list', $request->project_id);
    }

    public function update(Request $request, $id)
    {
        /* -------------------------------------------------------------------------- */
        /*                                  Validate                                  */
        // /* -------------------------------------------------------------------------- */
        $request->validate([
            'report_number' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'report_type' => 'required',
            'reports' => 'required'
        ]);
        /* -------------------------------------------------------------------------- */
        /*                                Create report                               */
        /* -------------------------------------------------------------------------- */
        $report = Report::find($id);
        $report->report_number = $request->report_number;
        $report->start_date = $request->start_date;
        $report->end_date = $request->end_date;
        $report->report_type = $request->report_type;
        $report->project_id = $request->project_id;
        $report->studio_id = $request->studio_id;
        $report->user_id = $request->user_id;
        $report->save();
        /* -------------------------------------------------------------------------- */
        /*                            Find project with id                            */
        /* -------------------------------------------------------------------------- */
        $project = Project::find($request->project_id);
        /* -------------------------------------------------------------------------- */
        /*                                 Get region                                 */
        /* -------------------------------------------------------------------------- */
        $region = strtolower($project->regions->name);
        /* -------------------------------------------------------------------------- */
        /*                          Insert files to directory                         */
        /* -------------------------------------------------------------------------- */
        foreach ($request->file('reports') as $fileRequest) {
            $file = $fileRequest;
            $fileName = $fileRequest->getClientOriginalName();
            $filePath = 'tecnico/' . $region . '/' . $project->id . '/' . $request->studio_id . '/' . $id . '/' . $fileName;
            Storage::disk('s3')->put($filePath, file_get_contents($file));
        }
        /* -------------------------------------------------------------------------- */
        /*                                 Redirect to                                */
        /* -------------------------------------------------------------------------- */
        // return redirect()->route('studies-list', $request->project_id);
        return redirect()->route('reports-list', [$project->id, $request->studio_id]);
    }
}
