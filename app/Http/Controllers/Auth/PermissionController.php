<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permission\Permission;
use App\Models\Permission\Role;

class PermissionController extends Controller
{

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $roles = Role::get();
        $permissions = Permission::get();
        return view('auth.role.index', compact('roles', 'permissions'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, ['name' => 'required|unique:roles']);

        if (Role::create($request->only('name'))) {
            toastr()->success('Role Added');
        }

        return redirect()->back();
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        if ($role = Role::findOrFail($id)) {
            // admin role has everything
            if ($role->name === 'Admin') {
                $role->syncPermissions(Permission::all());
                return redirect()->route('admin.role.index');
            }

            $permissions = $request->get('permissions', []);
            $role->syncPermissions($permissions);
            toastr()->success($role->name . ' permissions has been updated.');

        } else {
            toastr()->error('Role with id ' . $id . ' note found.');
        }

        return redirect()->route('admin.role.index');
    }
}
