<?php

namespace App\Http\Controllers;

use App\Models\Study;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudyController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:config');
    }

    public function index(Request $request)
    {
        if ($request->search) {
            $studies = Study::where('name', 'like', '%' . $request->search . '%')->paginate(10);
        } else {
            $studies = Study::paginate(10);
        }
        return view('Study.index', compact('studies'));
    }

    public function create()
    {
        /* -------------------------------------------------------------------------- */
        /*                           Return coordinator user                          */
        /* -------------------------------------------------------------------------- */
        $users = DB::select('select * from model_has_roles where role_id = ?', [3]);
        $userArray = [];
        foreach ($users as $user) {
            $coordinator = User::find($user->model_id);
            array_push($userArray, $coordinator);
        }
        return view('Study.create', compact('userArray'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'user_id' => 'required|min:1',
        ]);
        $study = new Study();
        $study->name = $request->name;
        $study->save();
        $study = Study::latest('id')->first();
        $study->users()->attach($request->user_id);
        return redirect()->route('estudios.index');
    }

    public function edit($id)
    {
        $study = Study::find($id);
        /* -------------------------------------------------------------------------- */
        /*                              Initial Validate                              */
        /* -------------------------------------------------------------------------- */
        if ($study == null) {
            return view('errors.4032');
        }
        $users = DB::select('select * from model_has_roles where role_id = ?', [3]);
        $userArray = [];
        foreach ($users as $user) {
            $coordinator = User::find($user->model_id);
            array_push($userArray, $coordinator);
        }
        return view('Study.edit', compact('study', 'userArray'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'user_id' => 'required|min:1',
        ]);
        $study = Study::find($id);
        /* -------------------------------------------------------------------------- */
        /*                              Initial Validate                              */
        /* -------------------------------------------------------------------------- */
        if ($study == null) {
            return view('errors.4032');
        }
        $study->name = $request->name;
        $study->save();
        $study->users()->sync($request->user_id);
        return redirect()->route('estudios.index');
    }

    public function destroy($id)
    {
        $study = Study::find($id);
        /* -------------------------------------------------------------------------- */
        /*                              Initial Validate                              */
        /* -------------------------------------------------------------------------- */
        if ($study == null) {
            return view('errors.4032');
        }
        $study->delete();
        return redirect()->route('estudios.index');
    }
}
