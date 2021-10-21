<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        //Deverá retornar todos os usuários rejeitando o que for admin
        $usuarios = User::all()->reject(function ($user) {
            return $user->hasRole('admin');
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

        toastr()->success('Usuário:' . $user->name . ' criado com sucesso');
        return redirect()->route('admin.users.index');
        //return redirect()->route('admin.users.index')->with('success', 'Usuário:' . $user->name . ' criado com sucesso');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view(null, compact('user'));
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
        /*  activity()->performedOn($user)
              ->causedBy(auth()->user())
              //    ->withProperties(['customProperty' => 'customValue'])
              ->log('Atualizou o usuário ' . $user->name);
        */
        toastr()->success('Usuário:' . $user->name . ' atualizado com sucesso');
        return redirect()->route('admin.users.index')->with('success', $user);
    }


    public function destroy($id)
    {
        $user = User::destroy($id);
        /* activity()->performedOn($user)
             ->causedBy(auth()->user())
             //    ->withProperties(['customProperty' => 'customValue'])
             ->log('Deletou o usuário ' . $user->name);
        */
        return redirect()->route('admin.users.index')->with('success', $user);
    }

    /**
     * Loga no usuário pela ID, sem autenticação
     * !Perigoso!
     *
     * @param mixed $id
     * @return void
     */
    protected function logInUser($id)
    {

        Auth::loginUsingId($id);
        return redirect()->route('redirDASH');
    }
}
