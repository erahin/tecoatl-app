<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Region;
use Illuminate\Support\Facades\DB;

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
    public function showPiechartbyRegion()
    {
        $regions = Region::all();
        $projectArray = [];
        foreach ($regions as $region) {
            $projects = Project::where('region_id', '=', $region->id)->get();
            array_push($projectArray, $projects);
        }
        $percentArray = [];
        if (count(Project::all()) > 0) {
            for ($i = 0; $i < count($projectArray); $i++) {
                $totalProject = count(Project::all());
                $percent = (count($projectArray[$i]) * 100) / $totalProject;
                $percentArray[] = ['name' => $regions[$i]->name, 'y' => $percent];
            }
        }
        return view('ProjectQuery.allProject', ["data" => json_encode($percentArray)]);
    }
    public function projectWithUser()
    {
        $projects = DB::table('projects')
            ->join('users', 'projects.user_id', '=', 'users.id')
            ->select('projects.*', 'users.name as user')
            ->get();
        return view('ProjectQuery.project-query', compact('projects'));
    }
}
