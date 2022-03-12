<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Region;
use App\Models\Study;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:proyectos.index')->only('index');
        $this->middleware('can:proyectos.create')->only('create', 'store');
        $this->middleware('can:proyectos.edit')->only('edit', 'update');
        $this->middleware('can:proyectos.destoy')->only('destoy');
    }
    public function index(Request $request)
    {
        $regions = Region::all();
        if ($request->search) {
            $projects = Project::where('place', 'like', $request->search)->paginate(10);
        } else {
            $projects = Project::paginate(10);
        }
        return view('Project.index', compact('projects', 'regions'));
    }

    public function create()
    {
        $regions = Region::pluck('name', 'id');
        $studies = Study::all();
        return view('Project.create', compact('regions', 'studies'));
    }

    public function store(Request $request)
    {
        /* -------------------------------------------------------------------------- */
        /*                                  validate                                  */
        /* -------------------------------------------------------------------------- */
        $request->validate([
            'place' => 'required',
            'abbreviation' => 'required',
            'region_id' => 'required',
        ]);
        /* -------------------------------------------------------------------------- */
        /*                                create projet                               */
        /* -------------------------------------------------------------------------- */
        $project = new Project();
        $project->place = $request->place;
        $project->abbreviation = $request->abbreviation;
        $project->region_id = $request->region_id;
        $project->user_id = $request->user_id;
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
        }
        return redirect()->route('proyectos.index');
    }

    public function edit($id)
    {
        $regions = Region::pluck('name', 'id');
        $studies = Study::all();
        $project = Project::find($id);
        return view(
            'Project.edit',
            compact('regions', 'project', 'studies')
        );
    }

    public function update(Request $request, $id)
    {
        /* -------------------------------------------------------------------------- */
        /*                                  validate                                  */
        /* -------------------------------------------------------------------------- */
        $request->validate([
            'place' => 'required',
            'abbreviation' => 'required',
            'region_id' => 'required',
            // 'file' => 'required',
        ]);
        /* -------------------------------------------------------------------------- */
        /*                                create projet                               */
        /* -------------------------------------------------------------------------- */
        $project = Project::find($id);
        $project->place = $request->place;
        $project->abbreviation = $request->abbreviation;
        $project->region_id = $request->region_id;
        $project->user_id = $request->user_id;
        // $project_studys = DB::select('select * from projects_studies where project_id = ?', [$id]);
        /* -------------------------------------------------------------------------- */
        /*                                 Get region                                 */
        /* -------------------------------------------------------------------------- */
        // $region = Region::find($request->region_id);
        // $region = strtolower($region->name);
        // /* -------------------------------------------------------------------------- */
        // /*                              Update directory                              */
        // /* -------------------------------------------------------------------------- */
        // foreach ($project->studys as $registre) {
        //     foreach ($request->studie_id as $key) {
        //         // if ($key == $registre->id) {
        //         //     Storage::disk('s3')->makeDirectory('tecnico/' . $region . '/' . $project->id . '/' . $registre->id);
        //         // } else {
        //         //     Storage::disk('s3')->deleteDirectory('tecnico/' . $region . '/' . $project->id . '/' . $registre->id);
        //         // }
        //     }
        // }
        $project->save();
        $project->studys()->sync($request->studie_id);
        return redirect()->route('proyectos.index');
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
        /*                              Delete directory                              */
        /* -------------------------------------------------------------------------- */
        Storage::disk('s3')->deleteDirectory('tecnico/' . $region . '/' . $project->id . '/');
        /* -------------------------------------------------------------------------- */
        /*                               Delete project                               */
        /* -------------------------------------------------------------------------- */
        $project->delete();
        return redirect()->route('proyectos.index');
    }
}
