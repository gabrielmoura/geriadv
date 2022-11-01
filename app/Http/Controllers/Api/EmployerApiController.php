<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployerApiController extends Controller
{
    public function index()
    {
        return Employee::all();
    }

    public function show($id)
    {
        return Employee::find($id);
    }

    /**
     * @param Request $request
     * @return Company|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|never|object|null
     */
    private function getCompany(Request $request)
    {
        $company = Company::where('id', $request->company_id);
        if ($request->has('pid')) {
            $company->orWhere('pid', '=', $request->pid);
        }
        $company = $company->first();
        return (!$company) ? abort(404, __('error.NotFound')) : $company;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|never
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'last_name',
            'pid' => 'string',
            'company_id' => 'integer|required_without:pid',
            // 'user_id' => 'integer|required',
            'cpf',
            'rg',
            'password' => 'required|string',
            'email' => 'required|email|unique:users',
            'tel0',
            'tel1',
            'sex',
            'birth_date',
            'cep',
            'address',
            'number' => 'integer',
            'complement' => 'string',
            'district',
            'city',
            'state',
        ]);
        try {
            $company = $this->getCompany($request);
            $employeeData = $request->only([
                'name',
                'last_name',
                'cpf',
                'rg',
                'email',
                'tel0',
                'tel1',
                'sex',
                'birth_date',
                'cep',
                'address',
                'number',
                'complement',
                'district',
                'city',
                'state'
            ]);
            $employeeData['company_id'] = $company->id ?? $request->company_id;

            $userData = $request->only(['email', 'name']);
            $userData['password'] = Hash::make($request->password);
            $user = User::create($userData);
            $user->assignRole('employees');
            $employeeData['user_id'] = $user->id;

            return response()->json(Employee::create($employeeData), 201);
        } catch (\Throwable $throwable) {
            return abort(400, $throwable->getMessage() . $throwable->getCode());
        }
    }

    public function delete(Request $request)
    {
        return $this->getEmployee($request)->delete() ? response()->json('OK') : abort(422, __('error.NotAllowed'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse|never
     */
    public function update(Request $request, $id)
    {

        try {
            $employe = Employee::where('id', $id)
                ->update($request->only([
                    'name',
                    'last_name',
                    'cpf',
                    'rg',
                    'email',
                    'tel0',
                    'tel1',
                    'sex',
                    'birth_date',
                    'cep',
                    'address',
                    'number',
                    'complement',
                    'district',
                    'city',
                    'state'
                ]));
            if ($employe) {
                return response()->json('ok');
            } else {
                throw new \Exception('Error ao salvar', 400);
            }

        } catch (\Throwable $throwable) {
            return abort(400, $throwable->getMessage());
        }
    }

    public function ban(Request $request)
    {
        return $this->banToggle($request, true);
    }

    public function unBan(Request $request)
    {
        return $this->banToggle($request, false);
    }

    /**
     * @param Request $request
     * @return Employee|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|never|object
     */
    private function getEmployee(Request $request)
    {
        $request->validate(['id' => 'integer', 'email' => 'email', 'pid' => 'string']);
        $employee = Employee::where('id', $request->id);

        if ($request->has('email')) {
            $employee->orWhere('email', '=', $request->email);
        }
        if ($request->has('pid')) {
            $employee->orWhere('pid', '=', $request->pid);
        }
        $employee = $employee->first();

        return (!$employee) ? abort(404, __('error.NotFound')) : $employee;
    }

    private function banToggle(Request $request, bool $banned)
    {
        $this->middleware('role:admin');
        $employee = $this->getEmployee($request);
        $employee->banned = $banned;
//        $employee->fill(['banned'=>$banned]);

        return ($employee->save()) ? response()->json('OK') : abort(422, __('error.NotAllowed'));
    }
}
