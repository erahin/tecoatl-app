<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Region;
use App\Models\Study;
use Illuminate\Http\Request;

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
        // $project = new Project();
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
        $request->validate([
            'place' => 'required',
            'abbreviation' => 'required',
            'region_id' => 'required',
        ]);
        $project = new Project();
        $project->place = $request->place;
        $project->abbreviation = $request->abbreviation;
        $project->region_id = $request->region_id;
        $project->save();
        $project = Project::latest('id')->first();
        $project->studys()->attach($request->studie_id);
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
        return view('Project.edit', compact('regions', 'project', 'studies'));
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
        $request->validate([
            'place' => 'required',
            'abbreviation' => 'required',
            'region_id' => 'required',
        ]);
        $project = Project::find($id);
        $project->place = $request->place;
        $project->abbreviation = $request->abbreviation;
        $project->region_id = $request->region_id;
        $project->save();
        $project->studys()->sync($request->studie_id);
        return redirect()->route('proyectos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = Project::find($id);
        $project->delete();
        return redirect()->route('proyectos.index');
    }
}
