<?php

namespace App\Http\Controllers;

use App\Models\Administrative;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdministrativeController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:administrativos.index')->only('index');
        $this->middleware('can:administrativos.create')->only('create', 'store');
        $this->middleware('can:administrativos.edit')->only('edit', 'update');
        $this->middleware('can:administrativos.destoy')->only('destoy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /* -------------------------------------------------------------------------- */
        /*                                 Get user id                                */
        /* -------------------------------------------------------------------------- */
        $user = Auth::user();
        $idUser = $user->id;
        $user = $user->roles[0]->name;
        if ($request->search) {
            if ($user == "Jefa subadministrativa") {
                $administratives = DB::table('users')
                    ->join('administratives', 'users.id', '=', 'administratives.user_id')
                    ->select('administratives.*')
                    ->where('administratives.user_id', '=', $idUser)
                    ->where('administratives.name', 'like', '%' . $request->search . '%')
                    ->paginate(10);
            } else {
                $administratives = Administrative::where('name', 'like', '%' . $request->search . '%')->paginate(10);
            }
        } else {
            if ($user == "Jefa subadministrativa") {
                $administratives = DB::table('users')
                    ->join('administratives', 'users.id', '=', 'administratives.user_id')
                    ->select('administratives.*')
                    ->where('administratives.user_id', '=', $idUser)
                    ->paginate(10);
            } else {
                $administratives = Administrative::paginate(10);
            }
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
        /* -------------------------------------------------------------------------- */
        /*                           Return subarea user                              */
        /* -------------------------------------------------------------------------- */
        $users = DB::select('select * from model_has_roles where role_id = ?', [6]);
        $userArray = [];
        foreach ($users as $user) {
            $coordinator = User::find($user->model_id);
            array_push($userArray, $coordinator);
        }
        return view('Administrative.create', compact('userArray'));
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
        $administrative->user_id = $request->user_id;
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
        /* -------------------------------------------------------------------------- */
        /*                           Return subarea user                              */
        /* -------------------------------------------------------------------------- */
        $users = DB::select('select * from model_has_roles where role_id = ?', [6]);
        $userArray = [];
        foreach ($users as $user) {
            $coordinator = User::find($user->model_id);
            array_push($userArray, $coordinator);
        }
        $administrative = Administrative::find($id);
        if ($administrative == null) {
            return view('errors.4032');
        }
        return view('Administrative.edit', compact('administrative', 'userArray'));
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
        $administrative->user_id = $request->user_id;
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
