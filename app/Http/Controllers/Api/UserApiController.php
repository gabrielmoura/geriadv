<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class UserApiController extends Controller
{
    public function index()
    {
        return User::all();
    }

    public function show($id)
    {
        return User::find($id);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function update(Request $request, $id)
    {
        $data = $request->only(['email', 'name']);
        $data['password'] = Hash::make($request->password);
        $user = User::where('id', $id)
            ->update($data);
        if ($user) {
            return response()->json('ok');
        } else {
            throw new \Exception('Error ao salvar', 400);
        }
    }

    public function storeAdmin(Request $request)
    {
        $data = $request->only(['email', 'name']);
        $data['password'] = Hash::make($request->password);
        try {
            $user = User::create($data);
            $user->assignRole('admin');
        } catch (\Throwable $throwable) {
            report($throwable);
            abort(400, __('error.NotAllowed'));
        }
    }

    public function permissionTo(Request $request)
    {
        try {
            $permission = Permission::where('name', 'use_api')->get();
            $user = User::where('id', $request->id);
            if ($request->has('email')) {
                $user->orWhere('email', $request->email);
            }
            $user->first()->syncPermissions($permission);
            return request()->json('ok');
        } catch (\Throwable $throwable) {
            report($throwable);
            abort(400, __('error.NotAllowed'));
        }
    }
}
