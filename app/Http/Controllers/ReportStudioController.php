<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReportStudioController extends Controller
{
    public function index()
    {
        //
    }
    public function create()
    {
        // return view('ReportStudio.create');
    }
    public function store(Request $request)
    {
        /* -------------------------------------------------------------------------- */
        /*                                  Validate                                  */
        /* -------------------------------------------------------------------------- */
        $request->validate([
            'report_number' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);
        /* -------------------------------------------------------------------------- */
        /*                                Create report                               */
        /* -------------------------------------------------------------------------- */
        $report = new Report();
        $report->repor_number = $request->report_number;
        $report->start_date = $request->start_date;
        $report->end_date = $request->end_date;
        $report->project_id = $request->project_id;
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
        foreach ($request->file('file') as $fileRequest) {
            $file = $fileRequest;
            $fileName = $fileRequest->getClientOriginalName();
            $filePath = 'tecnico/' . $region . '/' . $project->id . '/' . $request->studio_id . '/' . $fileName;
            Storage::disk('s3')->put($filePath, file_get_contents($file));
        }
        /* -------------------------------------------------------------------------- */
        /*                                 Redirect to                                */
        /* -------------------------------------------------------------------------- */
        return redirect()->route('proyectos.index');
    }

    public function show($id)
    {
        //
    }
    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
