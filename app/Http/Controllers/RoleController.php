<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct()
    {
        // $this->middleware('can:roles.index')->only('index');
        // $this->middleware('can:roles.create')->only('create', 'store');
        // $this->middleware('can:roles.edit')->only('edit', 'update');
        // $this->middleware('can:roles.destoy')->only('destoy');
        $this->middleware('can:config');
    }
    public function index()
    {
        $roles = Role::paginate(10);
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
            'name' => 'required',
            'permissions' => 'required|min:1'
        ]);
        $role = new Role();
        $role->name = $request->name;
        $role->save();
        $role = Role::latest('id')->first();
        $role->permissions()->sync($request->permissions);
        return redirect()->route('roles.index');
    }

    public function edit($id)
    {
        $permissions = Permission::all();
        $role = Role::find($id);
        return view('Role.edit', compact('permissions', 'role'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'permissions' => 'required|min:1'

        ]);
        $role = Role::find($id);
        $role->name = $request->name;
        $role->save();
        $role->permissions()->sync($request->permissions);
        return redirect()->route('roles.index');
    }

    public function destroy($id)
    {
        $role = Role::find($id);
        $role->delete();
        return redirect()->route('roles.index');
    }
}
