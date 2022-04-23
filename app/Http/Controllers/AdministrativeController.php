<?php

namespace App\Http\Controllers;

use App\Models\Administrative;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdministrativeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->search) {
            $administratives = Administrative::where('name', 'like', '%' . $request->search . '%')->paginate(10);
        } else {
            $administratives = Administrative::paginate(10);
        }
        return view('Administrative.index', compact('administratives'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Administrative.create');
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
        $administrative = new Administrative();
        $administrative->name = $request->name;
        $administrative->save();
        $administrative = Administrative::latest('id')->first();
        /* -------------------------------------------------------------------------- */
        /*                           Create departamet directory                      */
        /* -------------------------------------------------------------------------- */
        Storage::disk('s3')->makeDirectory('administrativo/' . $administrative->id);
        return redirect()->route('administrativos.index');
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
        $administrative = Administrative::find($id);
        if ($administrative == null) {
            return view('errors.4032');
        }
        return view('Administrative.edit', compact('administrative'));
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
        $administrative = Administrative::find($id);
        if ($administrative == null) {
            return view('errors.4032');
        }
        $administrative->name = $request->name;
        $administrative->save();
        return redirect()->route('administrativos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $administrative = Administrative::find($id);
        if ($administrative == null) {
            return view('errors.4032');
        }
        $administrative->delete();
        /* -------------------------------------------------------------------------- */
        /*                              Delete directory                              */
        /* -------------------------------------------------------------------------- */
        Storage::disk('s3')->deleteDirectory('administrativo/' . $id . '/');
        return redirect()->route('administrativos.index');
    }
}
