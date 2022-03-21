<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Region;
use App\Models\Study;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ProjectByRegion extends Controller
{
    public function projectByRegion($id)
    {
        $status = ["Por iniciar", "En desarrollo", "Concluido"];
        $region = Region::find($id);
        $projects = Project::where('region_id', '=', $id)->paginate(10);
        return view('Project.index', compact('projects', 'status', 'region', 'id'));
    }
    public function searchProjectByRegion(Request $request, $id)
    {
        if ($request->search) {
            $projects = DB::table('projects')
                ->where('place', 'like', '%' . $request->search . '%')
                // ->orWhere('abbreviation', 'like', '%' . $request->search . '%')
                ->where('region_id', '=', $id)
                ->paginate(10);
        }
        $region = Region::find($id);
        $status = ["Por iniciar", "En desarrollo", "Concluido"];
        return view('Project.index', compact('projects', 'region', 'status', 'id'));
    }
    public function createProjectByRegion($id)
    {
        $regions = Region::pluck('name', 'id');
        $status = ["Por iniciar", "En desarrollo", "Concluido"];
        $studies = Study::all();
        return view('Project.create', compact('regions', 'studies', 'status', 'id'));
    }
}
