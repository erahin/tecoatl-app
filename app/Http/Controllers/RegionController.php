<?php

namespace App\Http\Controllers;

use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RegionController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:config.ti');
    }

    public function index(Request $request)
    {

        /* -------------------------------------------------------------------------- */
        /*                            Array name and region                           */
        /* -------------------------------------------------------------------------- */
        $regionArray = "";
        $regionNameArray = "";
        $regions = Region::all();
        for ($i = 0; $i < count($regions); $i++) {
            if ($i == count($regions) - 1) {
                $regionArray .= $regions[$i]->id;
                $regionNameArray .= $regions[$i]->name;
            } else {
                $regionArray .= $regions[$i]->id . ',';
                $regionNameArray .= $regions[$i]->name . ',';
            }
        }
        /* -------------------------------------------------------------------------- */
        /*                                   Search                                   */
        /* -------------------------------------------------------------------------- */
        if ($request->search) {
            $regions = Region::where('name', 'like', '%' . $request->search . '%')->paginate(10);
        } else {
            $regions = Region::paginate(10);
        }
        return view('Region.index', compact('regions', 'regionArray', 'regionNameArray'));
    }

    public function create()
    {
        return view('Region.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
        ]);
        $region = new Region();
        $region->name = $request->name;
        $region->save();
        /* -------------------------------------------------------------------------- */
        /*                           Create region directory                          */
        /* -------------------------------------------------------------------------- */
        Storage::disk('s3')->makeDirectory('tecnico/' . strtolower($request->name));
        return redirect()->route('regiones.index');
    }

    public function edit($id)
    {
        $region = Region::find($id);
        /* -------------------------------------------------------------------------- */
        /*                              Initial Validate                              */
        /* -------------------------------------------------------------------------- */
        if ($region == null) {
            return view('errors.4032');
        }
        return view('Region.edit', compact('region'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string'],
        ]);
        $region = Region::find($id);
        /* -------------------------------------------------------------------------- */
        /*                              Initial Validate                              */
        /* -------------------------------------------------------------------------- */
        if ($region == null) {
            return view('errors.4032');
        }
        $region->name = $request->name;
        $region->save();
        return redirect()->route('regiones.index');
    }

    public function destroy($id)
    {
        $region = Region::find($id);
        /* -------------------------------------------------------------------------- */
        /*                              Initial Validate                              */
        /* -------------------------------------------------------------------------- */
        if ($region == null) {
            return view('errors.4032');
        }
        $region->delete();
        /* -------------------------------------------------------------------------- */
        /*                           Destry region directory                          */
        /* -------------------------------------------------------------------------- */
        Storage::disk('s3')->deleteDirectory('tecnico/' . strtolower($region->name) . '/');
        return redirect()->route('regiones.index');
    }
}
