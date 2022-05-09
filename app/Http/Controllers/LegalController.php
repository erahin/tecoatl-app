<?php

namespace App\Http\Controllers;

use App\Models\Legal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LegalController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:legal.index')->only('index');
        $this->middleware('can:legal.create')->only('create', 'store');
        $this->middleware('can:legal.edit')->only('edit', 'update');
        $this->middleware('can:legal.destroy')->only('destroy');
    }
    public function index(Request $request)
    {
        $legals = Legal::paginate(10);
        if ($request->search) {
            $legals = Legal::where('name', 'like', '%' . $request->search . '%')->paginate(10);
        }
        return view('Legal.index', compact('legals'));
    }

    public function create()
    {
        return view('Legal.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);
        $legal = new Legal();
        $legal->name = $request->name;
        $legal->save();
        $legal = Legal::latest('id')->first();
        /* -------------------------------------------------------------------------- */
        /*                           Create departamet directory                      */
        /* -------------------------------------------------------------------------- */
        Storage::disk('s3')->makeDirectory('legal/' . $legal->id);
        return redirect()->route('legal.index');
    }

    public function edit($id)
    {
        $legal = Legal::find($id);
        if ($legal == null) {
            return view('errors.4032');
        }
        return view('Legal.edit', compact('legal'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required'
        ]);
        $legal = Legal::find($id);
        if ($legal == null) {
            return view('errors.4032');
        }
        $legal->name = $request->name;
        $legal->save();
        return redirect()->route('legal.index');
    }

    public function destroy($id)
    {
        $legal = Legal::find($id);
        if ($legal == null) {
            return view('errors.4032');
        }
        $legal->delete();
        /* -------------------------------------------------------------------------- */
        /*                              Delete directory                              */
        /* -------------------------------------------------------------------------- */
        Storage::disk('s3')->deleteDirectory('legal/' . $legal->name . '/');
        return redirect()->route('legal.index');
    }
}
