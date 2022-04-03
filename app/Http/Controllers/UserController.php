<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        // $this->middleware('can:usuarios.index')->only('index');
        // $this->middleware('can:usuarios.create')->only('create', 'store');
        // $this->middleware('can:usuarios.edit')->only('edit', 'update');
        // $this->middleware('can:usuarios.destoy')->only('destoy');
        $this->middleware('can:config');
    }

    public function index(Request $request)
    {
        if ($request->search) {
            $users = User::where('name', 'like', '%' . $request->search . '%')->paginate(10);
        } else {
            $users = User::paginate(10);
        }
        return view('User.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('User.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users',
            ],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['required'],
            'roles' => 'required|min:1'
        ]);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->phone = '+52' . $request->phone;
        $user->save();
        $user->roles()->attach($request->roles);
        return redirect()->route('usuarios.index');
    }

    public function edit($id)
    {
        $roles = Role::all();
        $user = User::find($id);
        return view('User.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
            'phone' => ['required'],
            'roles' => 'required|min:1'
        ]);
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->phone = '+52' . $request->phone;
        $user->save();
        $user->roles()->sync($request->roles);
        return redirect()->route('usuarios.index');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->route('usuarios.index');
    }
}
