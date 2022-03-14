<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Region;
use Illuminate\Http\Request;

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
    public function showRegionForm(Request $request)
    {
        $regions = Region::pluck('name', 'id');
        $id = $request->region_id;
        $status = ["Por iniciar", "En desarrollo", "Concluido", "Cancelado"];
        if ($id) {
            $projects = Project::where('region_id', '=', $id)->paginate(10);
        } else {
            $projects = null;
        }
        return view('ProjectQuery.regionForm', compact('regions', 'projects', 'status', 'id'));
    }
}
