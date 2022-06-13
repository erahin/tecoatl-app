<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Region;
use App\Models\Study;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProjectByRegion extends Controller
{
    public function projectByRegion($id)
    {
        /* -------------------------------------------------------------------------- */
        /*                                 Get user id                                */
        /* -------------------------------------------------------------------------- */
        $user = Auth::user();
        $idUser = $user->id;
        /* -------------------------------------------------------------------------- */
        /*                               Find view data                               */
        /* -------------------------------------------------------------------------- */
        $region = Region::find($id);
        /* -------------------------------------------------------------------------- */
        /*                              Initial Validate                              */
        /* -------------------------------------------------------------------------- */
        if ($region == null) {
            return view('errors.4032');
        }
        $status = ["Por iniciar", "En desarrollo", "Concluido", "Cancelado"];
        $users = DB::select('select * from model_has_roles where model_id = ?', [$idUser]);
        /* -------------------------------------------------------------------------- */
        /*                             Search data by user                            */
        /* -------------------------------------------------------------------------- */
        $projects = Project::where('region_id', '=', $id)->paginate(10);
        foreach ($users as $user) {
            if ($user->role_id == 3) {
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
    public function searchProjectByRegion(Request $request, $id)
    {
        /* -------------------------------------------------------------------------- */
        /*                               Find view data                               */
        /* -------------------------------------------------------------------------- */
        $region = Region::find($id);
        /* -------------------------------------------------------------------------- */
        /*                              Initial Validate                              */
        /* -------------------------------------------------------------------------- */
        if ($region == null) {
            return view('errors.4032');
        }
        $status = ["Por iniciar", "En desarrollo", "Concluido"];
        /* -------------------------------------------------------------------------- */
        /*                                 Get user id                                */
        /* -------------------------------------------------------------------------- */
        $user = Auth::user();
        $idUser = $user->id;
        /* -------------------------------------------------------------------------- */
        /*                               Find view data                               */
        /* -------------------------------------------------------------------------- */
        $users = DB::select('select * from model_has_roles where model_id = ?', [$idUser]);
        if ($request->search) {
            $projects = DB::table('projects')
                ->where('place', 'like', '%' . $request->search . '%')
                ->where('region_id', '=', $id)
                ->paginate(10);
            foreach ($users as $user) {
                if ($user->role_id == 3) {
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
