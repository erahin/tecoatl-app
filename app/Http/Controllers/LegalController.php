<?php

namespace App\Http\Controllers;

use App\Models\Legal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        /* -------------------------------------------------------------------------- */
        /*                                Validate user                               */
        /* -------------------------------------------------------------------------- */
        $user = Auth::user();
        $idUser = $user->id;
        $isLegalUser = false;
        $users = DB::select('select * from model_has_roles where model_id = ?', [$idUser]);
        foreach ($users as $user) {
            if ($user->role_id == 7) {
                $isLegalUser = true;
            }
        }
        if ($request->search) {
            $legals = Legal::where('name', 'like', '%' . $request->search . '%')->paginate(10);
        }
        $legals = Legal::paginate(10);
        return view('Legal.index', compact('legals', 'isLegalUser'));
    }

    public function create()
    {
        /* -------------------------------------------------------------------------- */
        /*                           Return subarea legal user                        */
        /* -------------------------------------------------------------------------- */
        $users = DB::select('select * from model_has_roles where role_id = ?', [7]);
        $userArray = [];
        foreach ($users as $user) {
            $coordinator = User::find($user->model_id);
            array_push($userArray, $coordinator);
        }
        return view('Legal.create', compact('userArray'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'user_id' => 'required|min:1'
        ]);
        $legal = new Legal();
        $legal->name = $request->name;
        $legal->user_id = $request->user_id;
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
        /* -------------------------------------------------------------------------- */
        /*                           Return subarea legal user                        */
        /* -------------------------------------------------------------------------- */
        $users = DB::select('select * from model_has_roles where role_id = ?', [7]);
        $userArray = [];
        foreach ($users as $user) {
            $coordinator = User::find($user->model_id);
            array_push($userArray, $coordinator);
        }
        return view('Legal.edit', compact('legal', 'userArray'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'user_id' => 'required|min:1'
        ]);
        $legal = Legal::find($id);
        if ($legal == null) {
            return view('errors.4032');
        }
        $legal->name = $request->name;
        $legal->user_id = $request->user_id;
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
