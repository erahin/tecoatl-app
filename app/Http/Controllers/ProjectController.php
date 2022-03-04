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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::paginate(10);
        $regions = Region::all();
        return view('Project.index', compact('projects', 'regions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $regions = Region::pluck('name', 'id');
        $studies = Study::all();
        return view('Project.create', compact('regions', 'studies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
        // foreach ($request->file('file') as $fileRequest) {
        //     $file = $fileRequest;
        //     $fileName = $fileRequest->getClientOriginalName();
        //     $filePath = 'project-inform/' . $project->id . '/' . $fileName;
        //     Storage::disk('s3')->put($filePath, file_get_contents($file));
        // }
        return redirect()->route('proyectos.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $regions = Region::pluck('name', 'id');
        $studies = Study::all();
        $project = Project::find($id);
        // $files = Storage::disk('s3')->allFiles('project-inform/' . $id . '/');
        // $fileName = [];
        // foreach ($files as $fileNameStorage) {
        //     $fileArray = explode('/', $fileNameStorage);
        //     array_push($fileName, $fileArray[2]);
        // }
        //  'fileName', 'files'
        return view(
            'Project.edit',
            compact('regions', 'project', 'studies')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
        // foreach ($request->file('file') as $fileRequest) {
        //     $file = $fileRequest;
        //     $fileName = $fileRequest->getClientOriginalName();
        //     $filePath = 'project-inform/' . $id . '/' . $fileName;
        //     echo file_get_contents($file);
        //     Storage::disk('s3')->put($filePath, file_get_contents($file));
        // }
        // return redirect()->route('proyectos.index');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
