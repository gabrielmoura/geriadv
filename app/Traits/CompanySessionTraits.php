<?php

namespace App\Traits;

use App\Models\Company;
use Illuminate\Support\Facades\Auth;

trait CompanySessionTraits
{

    /**
     * @return mixed
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function getCompanyId()
    {
        if (!session()->has('company.id')) {
            $userAuth = Auth::user();
            if (!$userAuth->hasRole('admin') && !session()->has('company.id')) {
                $employee = $userAuth->employee()->first();
                session(['employee.id' => $employee->id, 'employee.banned' => $employee->banned]);
                session(['company.id' => $employee->company()->first()->id]);
            }
        }
        return session()->get('company.id');
    }

    /**
     * @return mixed|null
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function getCompanyLogo()
    {
        if (session()->has('company.logo')) {
            return session()->get('company.logo');
        } else {
            return null;
        }
    }

    /**
     * @return mixed|null
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function getCompanyName()
    {
        if (session()->has('company.name')) {
            return session()->get('company.name');
        } else {
            return null;
        }
    }

    /**
     * @return Company|Company[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function getCompany()
    {
        if (session()->has('company.populated')) {
            return session()->get('company');
        } else {
            if (config('panel.forceCache')) {

                $x = cache()->remember('company:' . $this->getCompanyId(), 60 * 60 * 12, function () {
                    return Company::find($this->getCompanyId());
                });

                session()->put('company', $x);
                return $x;
            } else {
                return Company::find($this->getCompanyId());
            }
        }
    }

    /**
     * @return bool
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function forgetCompany()
    {
        return cache()->forget('company:' . $this->getCompanyId());
    }

    /**
     * @param string|int|array|\Spatie\Permission\Contracts\Role|\Illuminate\Support\Collection $role
     * @return bool
     */
    public function hasRole($role)
    {
        return Auth::user()->hasRole($role);
    }

    public function hasPermission($permission)
    {
        return Auth::user()->hasPermissionTo($permission);
    }

    /**
     * Popula sessão
     */
    public function populateSession()
    {
        try {
            // Insere dados da empresa na sessão caso não seja admin.
            $userAuth = Auth::user();
            if (!$userAuth->hasRole('admin')) {
                if (config('panel.forceCache')) {
                    $x = cache()->remember('company:' . $this->getCompanyId(), 60 * 60 * 12, function () {
                        return Company::find($this->getCompanyId());
                    });
                    $this->setData(['id', 'name', 'logo', 'banned'], $x);

                } else {
                    $employee = $userAuth->employee()->first();
                    $company = $employee->company()->first();
                    session(['employee.id' => $employee->id, 'employee.banned' => $employee->banned]);
                    $this->setData(['id', 'name', 'logo', 'banned'], $company);
                }
            }
        } catch (\Throwable $throwable) {

        }

    }

    private function setData($array, $obj)
    {
        foreach ($array as $item) {
            session(['company.' . $item => $obj->$item]);
        }
    }

    /**
     * @return bool
     */
    public function hasBanned()
    {
        return session()->get('company.banned') || session()->get('employee.banned');
    }

    /**
     * Retorna True se fim de semana não habilitado.
     * @return bool
     */
    private function blockFDS()
    {
        $weekend = now()->isWeekend();
        if ($this->getCompany()->config->has('weekend') && $this->getCompany()->config['weekend']) {
            return !$weekend;
        } else {
            return $weekend;
        }
    }

    /**
     * Retorna True se estiver fora do horário de funcionamento
     * @return bool
     */
    private function blockTimeBased()
    {
        return !now()->isBetween($this->getCompany()->config['opening'], $this->getCompany()->config['closing']);
    }

}
