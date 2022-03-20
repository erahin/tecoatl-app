<?php

namespace App\Http\Controllers;

use App\Models\Study;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudyController extends Controller
{
    public function __construct()
    {
        // $this->middleware('can:estudios.index')->only('index');
        // $this->middleware('can:estudios.create')->only('create', 'store');
        // $this->middleware('can:estudios.edit')->only('edit', 'update');
        // $this->middleware('can:estudios.destoy')->only('destoy');
        $this->middleware('can:config');
    }

    public function index()
    {
        $studies = Study::paginate(10);
        return view('Study.index', compact('studies'));
    }

    public function create()
    {
        return view('Study.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $study = new Study();
        $study->name = $request->name;
        $study->save();
        return redirect()->route('estudios.index');
    }

    public function edit($id)
    {
        $study = Study::find($id);
        return view('Study.edit', compact('study'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $study = Study::find($id);
        $study->name = $request->name;
        $study->save();
        return redirect()->route('estudios.index');
    }

    public function destroy($id)
    {
        $study = Study::find($id);
        $study->delete();
        return redirect()->route('estudios.index');
    }
}
