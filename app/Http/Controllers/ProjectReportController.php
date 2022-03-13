<?php

namespace App\Http\Controllers;

use App\Models\Project;

class ProjectReportController extends Controller
{
    public function projectStart()
    {
        $projects = Project::where('status', '=', '0')->paginate(10);
        return view('ProjectQuery.projectStart', compact('projects'));
    }
    public function projectInProcess()
    {
        $projects = Project::where('status', '=', '1')->paginate(10);
        return view('ProjectQuery.projectInProcess', compact('projects'));
    }
    public function completedProject()
    {
        $projects = Project::where('status', '=', '2')->paginate(10);
        return view('ProjectQuery.completedProject', compact('projects'));
    }
}
