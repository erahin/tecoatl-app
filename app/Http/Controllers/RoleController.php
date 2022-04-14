<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:config');
    }
    public function index(Request $request)
    {
        if ($request->search) {
            $roles = Role::where('name', 'like', '%' . $request->search . '%')->paginate(10);
        } else {
            $roles = Role::paginate(10);
        }
        return view('Role.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('Role.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'permissions' => ['required|min:1'],
        ]);
        $role = Role::firstOrCreate(['name' => $request->name]);
        $role->permissions()->sync($request->permissions);
        return redirect()->route('roles.index');
    }

    public function edit($id)
    {
        $role = Role::find($id);
        /* -------------------------------------------------------------------------- */
        /*                              Initial Validate                              */
        /* -------------------------------------------------------------------------- */
        if ($role == null) {
            return view('errors.4032');
        }
        $permissions = Permission::all();
        return view('Role.edit', compact('permissions', 'role'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'permissions' => ['required|min:1'],
        ]);
        $role = Role::find($id);
        /* -------------------------------------------------------------------------- */
        /*                              Initial Validate                              */
        /* -------------------------------------------------------------------------- */
        if ($role == null) {
            return view('errors.4032');
        }
        $role = Role::firstOrCreate([$role->name]);
        $role->permissions()->sync($request->permissions);
        return redirect()->route('roles.index');
    }

    public function destroy($id)
    {
        $role = Role::find($id);
        /* -------------------------------------------------------------------------- */
        /*                              Initial Validate                              */
        /* -------------------------------------------------------------------------- */
        if ($role == null) {
            return view('errors.4032');
        }
        $role->delete();
        return redirect()->route('roles.index');
    }
}
