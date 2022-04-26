<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Region;
use App\Models\Study;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:proyectos.create')->only('store');
        $this->middleware('can:proyectos.edit')->only('edit', 'update');
        $this->middleware('can:proyectos.destoy')->only('destoy');
    }
    public function store(Request $request)
    {
        /* -------------------------------------------------------------------------- */
        /*                                  validate                                  */
        /* -------------------------------------------------------------------------- */
        $request->validate([
            'place' => ['required', 'string'],
            'abbreviation' => ['required', 'string'],
            'status' => ['required', 'integer'],
            'region_id' => ['required', 'integer'],
            'studie_id' => 'required|min:1',
        ]);
        /* -------------------------------------------------------------------------- */
        /*                                 Get user id                                */
        /* -------------------------------------------------------------------------- */
        $user = Auth::user();
        $idUser = $user->id;
        /* -------------------------------------------------------------------------- */
        /*                                create projet                               */
        /* -------------------------------------------------------------------------- */
        $project = new Project();
        $project->place = $request->place;
        $project->abbreviation = $request->abbreviation;
        $project->status = $request->status;
        $project->region_id = $request->region_id;
        $project->user_id = $idUser;
        $project->save();
        $project = Project::latest('id')->first();
        $project->studys()->attach($request->studie_id);

        /* -------------------------------------------------------------------------- */
        /*                                 Get region                                 */
        /* -------------------------------------------------------------------------- */
        $region = Region::find($request->region_id);
        $region = strtolower($region->name);
        /* -------------------------------------------------------------------------- */
        /*                               Make directory                               */
        /* -------------------------------------------------------------------------- */
        foreach ($request->studie_id as $studie) {
            Storage::disk('s3')->makeDirectory('tecnico/' . $region . '/' . $project->id . '/' . $studie);
            /* -------------------------------------------------------------------------- */
            /*                                  Make key                                  */
            /* -------------------------------------------------------------------------- */
            $projects_studies_id = (int)($project->id . $studie);
            $query = 'update projects_studies set projects_studies_id =' . $projects_studies_id . ' where project_id = ? and study_id = ?';
            DB::update($query, [$project->id, $studie]);
        }
        /* -------------------------------------------------------------------------- */
        /*                        Make administrative directory                       */
        /* -------------------------------------------------------------------------- */
        Storage::disk('s3')->makeDirectory('administrativo/' . 1 . '/' . $project->id);
        return redirect()->route('projectByRegion', ['id' => $request->region_id]);
    }

    public function edit($id)
    {
        $project = Project::find($id);
        /* -------------------------------------------------------------------------- */
        /*                              Initial Validate                              */
        /* -------------------------------------------------------------------------- */
        if ($project == null) {
            return view('errors.4032');
        }
        $regions = Region::pluck('name', 'id');
        $studies = Study::all();
        $status = ["Por iniciar", "En desarrollo", "Concluido", "Cancelado"];
        return view(
            'Project.edit',
            compact('regions', 'project', 'studies', 'status', 'id')
        );
    }

    public function update(Request $request, $id)
    {
        /* -------------------------------------------------------------------------- */
        /*                                  validate                                  */
        /* -------------------------------------------------------------------------- */
        $request->validate([
            'place' => ['required', 'string'],
            'abbreviation' => ['required', 'string'],
            'status' => ['required', 'integer'],
            'region_id' => ['required', 'integer'],
            'studie_id' => 'required|min:1',
        ]);
        /* -------------------------------------------------------------------------- */
        /*                                 Get project                                */
        /* -------------------------------------------------------------------------- */
        $project = Project::find($id);
        /* -------------------------------------------------------------------------- */
        /*                                 Get region                                 */
        /* -------------------------------------------------------------------------- */
        $region = Region::find($request->region_id);
        /* -------------------------------------------------------------------------- */
        /*                              Initial Validate                              */
        /* -------------------------------------------------------------------------- */
        if ($project == null || $region == null) {
            return view('errors.4032');
        }
        $region = strtolower($region->name);
        /* -------------------------------------------------------------------------- */
        /*                                 Get user id                                */
        /* -------------------------------------------------------------------------- */
        $user = Auth::user();
        $idUser = $user->id;
        /* -------------------------------------------------------------------------- */
        /*                                create projet                               */
        /* -------------------------------------------------------------------------- */
        $project->place = $request->place;
        $project->abbreviation = $request->abbreviation;
        $project->status = $request->status;
        $project->region_id = $request->region_id;
        $project->user_id = $idUser;
        $project->save();
        $project->studys()->sync($request->studie_id);
        /* -------------------------------------------------------------------------- */
        /*                               Make directory                               */
        /* -------------------------------------------------------------------------- */
        if ($request->studie_id) {
            foreach ($request->studie_id as $studie) {
                Storage::disk('s3')->makeDirectory('tecnico/' . $region . '/' . $project->id . '/' . $studie);
                /* -------------------------------------------------------------------------- */
                /*                                  Make key                                  */
                /* -------------------------------------------------------------------------- */
                $projects_studies_id = (int)($project->id . $studie);
                $query = 'update projects_studies set projects_studies_id =' . $projects_studies_id . ' where project_id = ? and study_id = ?';
                DB::update($query, [$project->id, $studie]);
            }
        }
        return redirect()->route('projectByRegion', ['id' => $request->region_id]);
    }
    public function destroy($id)
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
        /*                              Initial Validate                              */
        /* -------------------------------------------------------------------------- */
        if ($region == null || $project == null) {
            return view('errors.4032');
        }
        /* -------------------------------------------------------------------------- */
        /*                              Delete directory                              */
        /* -------------------------------------------------------------------------- */
        Storage::disk('s3')->deleteDirectory('tecnico/' . $region . '/' . $project->id . '/');
        /* -------------------------------------------------------------------------- */
        /*                               Delete project                               */
        /* -------------------------------------------------------------------------- */
        $project->delete();
        return redirect()->route('projectByRegion', [$project->region_id]);
    }
}
