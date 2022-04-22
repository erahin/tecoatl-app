<?php

namespace App\Http\Controllers;

use App\Models\Departament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DepartamentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->search) {
            $departaments = Departament::where('name', 'like', '%' . $request->search . '%')->paginate(10);
        } else {
            $departaments = Departament::paginate(10);
        }
        return view('Departament.index', compact('departaments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Departament.create');
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
            'name' => 'required'
        ]);
        $departamet = new Departament();
        $departamet->name = $request->name;
        $departamet->save();
        /* -------------------------------------------------------------------------- */
        /*                           Create departamet directory                      */
        /* -------------------------------------------------------------------------- */
        Storage::disk('s3')->makeDirectory('administrativo/' . strtolower($request->name));
        return redirect()->route('departamentos.index');
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
        $departament = Departament::find($id);
        if ($departament == null) {
            return view('errors.4032');
        }
        return view('Departament.edit', compact('departament'));
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
        $departamet = Departament::find($id);
        if ($departamet == null) {
            return view('errors.4032');
        }
        $departamet->name = $request->name;
        $departamet->save();
        return redirect()->route('departamentos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $departamet = Departament::find($id);
        if ($departamet == null) {
            return view('errors.4032');
        }
        $departamet->delete();
        return redirect()->route('departamentos.index');
    }
}
