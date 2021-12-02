<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    public function index()
    {
        $userAuth = Auth::user();
        if ($userAuth->hasRole('admin')) {
            //Deverá retornar todos os usuários rejeitando o que for admin
            $usuarios = User::all()->reject(function ($user) {
                return $user->hasRole('admin');
            });
        }
        if ($userAuth->hasRole('manager')) {
            $usuarios = [];
            foreach (Company::find(session()->get('company_id'))->employees()->get() as $emp) {
                $usuarios[] = $emp->user()->first();
            }
        }

        return view('admin.users.index', compact('usuarios'));
    }


    public function create()
    {
        $form = ['route' => ['admin.users.store'], 'method' => 'post'];
        $company = [];
        foreach (Company::all() as $drole) {
            $company[] = ['value' => $drole->id, 'name' => $drole->name];
        }

        return view('admin.users.form', compact('form', 'company'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'password' => 'min:6|max:15|nullable|confirmed',
            'email' => 'required|email|unique:users'
        ]);
        $data = $request->all();
        $data['password'] = Hash::make(request('password'));
        $user = DB::transaction(function () use ($request, $data) {
            $user = User::create($data);
            $user->assignRole('manager');
            Employee::create([
                'name' => $request->name,
                'email' => $request->email
                , 'user_id' => $user->id
                , 'company_id' => $request->company
            ]);
            return $user;
        });


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
        $company = [];
        foreach (Company::all() as $drole) {
            $company[] = ['value' => $drole->id, 'name' => $drole->name];
        }
        return view('admin.users.form', compact('form', 'user', 'company'));
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'password' => 'min:6|max:15|nullable|confirmed',
            'email' => 'nullable|email'
        ]);

        $user = User::findOrFail($id);

        $data = $request->all();

        if (request()->has('password_confirmation')) {
            $data['password'] = Hash::make(request('password'));
        }

        if (request()->has('company') && request('company')) {
            Company::find($request->company)
                ->employees()
                ->create(['user_id' => $id, 'name' => $user->name, 'email' => $user->email]);
        }

        $user->update($data);
        /*  activity()->performedOn($user)
              ->causedBy(auth()->user())
              //    ->withProperties(['customProperty' => 'customValue'])
              ->log('Atualizou o usuário ' . $user->name);
        */
        toastr()->success('Usuário:' . $user->name . ' atualizado com sucesso');
        return redirect()->route('admin.users.index')->with('success', 'Usuário:' . $user->name . ' atualizado com sucesso');
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
