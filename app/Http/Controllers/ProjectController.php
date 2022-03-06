<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Region;
use App\Models\Study;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::paginate(10);
        $regions = Region::all();
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

    public function show($id)
    {
        /* -------------------------------------------------------------------------- */
        /*                                 Return data                                */
        /* -------------------------------------------------------------------------- */
        $regions = Region::pluck('name', 'id');
        $studies = Study::all();
        $project = Project::find($id);
        /* -------------------------------------------------------------------------- */
        /*                                 Get region                                 */
        /* -------------------------------------------------------------------------- */
        $region = strtolower($project->regions->name);
        /* -------------------------------------------------------------------------- */
        /*                                 Get studies                                */
        /* -------------------------------------------------------------------------- */
        $studies = DB::select('select study_id from projects_studies where project_id = ?', [$id]);
        /* -------------------------------------------------------------------------- */
        /*                                Get all files                               */
        /* -------------------------------------------------------------------------- */
        $arrayFiles = [];
        foreach ($studies as $studio) {
            $files = Storage::disk('s3')->allFiles('tecnico/' . $region . '/' . $id . '/' . $studio->study_id);
            array_push($arrayFiles, $files);
        }
        /* -------------------------------------------------------------------------- */
        /*                                Get only name                               */
        /* -------------------------------------------------------------------------- */
        $fileName = [];
        foreach ($files as $fileNameStorage) {
            $fileArray = explode('/', $fileNameStorage);
            array_push($fileName, $fileArray[4]);
        }
        return view(
            'Project.show',
            compact('regions', 'project', 'studies', 'arrayFiles')
        );
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
