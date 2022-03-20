<?php

namespace App\Http\Controllers;

use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RegionController extends Controller
{
    public function __construct()
    {
        // $this->middleware('can:regiones.index')->only('index');
        // $this->middleware('can:regiones.create')->only('create', 'store');
        // $this->middleware('can:regiones.edit')->only('edit', 'update');
        // $this->middleware('can:regiones.destoy')->only('destoy');
        $this->middleware('can:config');
    }

    public function index()
    {
        $regions = Region::paginate(10);
        return view('Region.index', compact('regions'));
    }

    public function create()
    {
        return view('Region.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $region = new Region();
        $region->name = $request->name;
        $region->save();
        return redirect()->route('regiones.index');
    }

    public function edit($id)
    {
        $region = Region::find($id);
        return view('Region.edit', compact('region'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $region = Region::find($id);
        $region->name = $request->name;
        $region->save();
        return redirect()->route('regiones.index');
    }

    public function destroy($id)
    {
        $region = Region::find($id);
        $region->delete();
        return redirect()->route('regiones.index');
    }
}
