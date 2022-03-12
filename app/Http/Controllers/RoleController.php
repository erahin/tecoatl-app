<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
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
            'permissions' => 'required'
        ]);
        $role = new Role();
        $role->name = $request->name;
        $role->guard_name = 'web';
        $role->save();
        $role = Permission::latest('id')->first();
        $role->permissions()->attach($request->permissions);
        return redirect()->route('roles.index');
    }

    public function edit($id)
    {
        $permissions = Permission::all();
        $role = Role::find($id);
        return view('Role.edit', compact('permissions'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'permissions' => 'required'
        ]);
        $role = Role::find($id);
        $role->name = $request->name;
        $role->guard_name = 'web';
        $role->save();
        $role->permissions()->sync($request->permissions);
        return redirect()->route('roles.index');
    }

    public function destroy($id)
    {
        $role = Role::find($id);
        $role->destroy();
        return redirect()->route('roles.index');
    }
}
