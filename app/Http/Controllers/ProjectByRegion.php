<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Region;
use App\Models\Study;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProjectByRegion extends Controller
{
    public function projectByRegion($id, $idUser)
    {
        /* -------------------------------------------------------------------------- */
        /*                               Find view data                               */
        /* -------------------------------------------------------------------------- */
        $status = ["Por iniciar", "En desarrollo", "Concluido"];
        $region = Region::find($id);
        $users = DB::select('select * from model_has_roles where model_id = ?', [$idUser]);
        /* -------------------------------------------------------------------------- */
        /*                             Search data by user                            */
        /* -------------------------------------------------------------------------- */
        foreach ($users as $user) {
            if ($user->role_id == 1 || $user->role_id == 2 || $user->role_id == 4 || $user->role_id == 5) {
                $projects = Project::where('region_id', '=', $id)->paginate(10);
            } else if ($user->role_id == 3) {
                $projects = DB::table('users')
                    ->join('users_studies', 'users.id', '=', 'users_studies.user_id')
                    ->join('studies', 'users_studies.study_id', '=', 'studies.id')
                    ->join('projects_studies', 'studies.id', '=', 'projects_studies.study_id')
                    ->join('projects', 'projects_studies.project_id', '=', 'projects.id')
                    ->select('projects.*')
                    ->where('projects.region_id', '=', $id)
                    ->where('users.id', '=', $idUser)
                    ->paginate(10);
            }
        }
        return view('Project.index', compact('projects', 'status', 'region', 'id'));
    }
    public function searchProjectByRegion(Request $request, $id, $idUser)
    {
        /* -------------------------------------------------------------------------- */
        /*                               Find view data                               */
        /* -------------------------------------------------------------------------- */
        $users = DB::select('select * from model_has_roles where model_id = ?', [$idUser]);
        if ($request->search) {
            foreach ($users as $user) {
                if ($user->role_id == 1 || $user->role_id == 2 || $user->role_id == 4 || $user->role_id == 5) {
                    $projects = DB::table('projects')
                        ->where('place', 'like', '%' . $request->search . '%')
                        ->where('region_id', '=', $id)
                        ->paginate(10);
                } else if ($user->role_id == 3) {
                    $projects = DB::table('users')
                        ->join('users_studies', 'users.id', '=', 'users_studies.user_id')
                        ->join('studies', 'users_studies.study_id', '=', 'studies.id')
                        ->join('projects_studies', 'studies.id', '=', 'projects_studies.study_id')
                        ->join('projects', 'projects_studies.project_id', '=', 'projects.id')
                        ->select('projects.*')
                        ->where('projects.region_id', '=', $id)
                        ->where('users.id', '=', $idUser)
                        ->where('projects.place', 'like', '%' . $request->search . '%')
                        ->paginate(10);
                }
            }
        }
        /* -------------------------------------------------------------------------- */
        /*                               Find view data                               */
        /* -------------------------------------------------------------------------- */
        $region = Region::find($id);
        $status = ["Por iniciar", "En desarrollo", "Concluido"];
        return view('Project.index', compact('projects', 'region', 'status', 'id'));
    }
    public function createProjectByRegion($id, $idUser)
    {
        $regions = Region::pluck('name', 'id');
        $status = ["Por iniciar", "En desarrollo", "Concluido"];
        $studies = Study::all();
        return view('Project.create', compact('regions', 'studies', 'status', 'id', 'idUser'));
    }
    public function destroyProjectByRegion($id, $idUser)
    {
        /* -------------------------------------------------------------------------- */
        /*                                Find project                                */
        /* -------------------------------------------------------------------------- */
        $project = Project::find($id);
        /* -------------------------------------------------------------------------- */
        /*                                 Get region                                 */
        /* -------------------------------------------------------------------------- */
        $region = Region::find($project->region_id);
        $region = strtolower($region->name);
        /* -------------------------------------------------------------------------- */
        /*                              Delete directory                              */
        /* -------------------------------------------------------------------------- */
        Storage::disk('s3')->deleteDirectory('tecnico/' . $region . '/' . $project->id . '/');
        /* -------------------------------------------------------------------------- */
        /*                               Delete project                               */
        /* -------------------------------------------------------------------------- */
        $project->delete();
        return redirect()->route('projectByRegion', ['id' => $project->region_id, 'idUser' => $idUser]);
    }
}
