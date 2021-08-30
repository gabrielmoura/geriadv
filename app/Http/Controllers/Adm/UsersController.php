<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    public function index()
    {
        //Como apenas o Super-admin tem acesso, ele sempre pegará o ID do super Admin logado.
        $usuarios = User::all()->reject(function ($user) {
            //return $user->id == auth()->id();
            return $user->hasRole('client');
        });
        return view('admin.users.index', compact('usuarios'));
    }


    public function create()
    {
        $form = ['route' => ['admin.users.store'], 'method' => 'post'];
        foreach (Role::all() as $drole) {
            $role[$drole->id] = $drole->name;
        }
        return view('admin.users.form', compact('form', 'role'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'password' => 'min:6|max:15|nullable|confirmed',
            'email' => 'required|email|unique:users'
        ]);
        $data = $request->all();
        $data['password'] = Hash::make(request('password'));
        $user = User::create($data);
        $user->assignRole($data['role']);
        //syncRoles
        toastr()->success('Usuário:' . $user->name . ' criado com sucesso');
        return redirect()->route('admin.users.index');
        //return redirect()->route('admin.users.index')->with('success', 'Usuário:' . $user->name . ' criado com sucesso');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $form = ['route' => ['admin.users.update', $id], 'method' => 'put'];
        $user = User::find($id);
        foreach (Role::all() as $drole) {
            $role[$drole->id] = $drole->name;
        }
        return view('admin.users.form', compact('form', 'user', 'role'));
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'password' => 'min:6|max:15|nullable|confirmed',
            'email' => 'required|email|unique:users'
        ]);

        $user = User::findOrFail($id);

        $data = $request->all();

        if (request()->has('password') && request('password')) {
            $data['password'] = Hash::make(request('password'));
        }

        if (request()->has('role') && request('role')) {
            $user->syncRoles(request('role'));
        }

        $user->update($data);
        return redirect()->route('admin.users.index')->with('success', $user);
    }


    public function destroy($id)
    {
        $user = User::destroy($id);
        return redirect()->route('admin.users.index')->with('success', $user);
    }
}
