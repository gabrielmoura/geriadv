<?php

namespace App\Traits;

use App\Models\Company;
use Illuminate\Support\Facades\Auth;

trait CompanySessionTraits
{

    /**
     * @return mixed|null
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    private function getCompanyId()
    {
        if (session()->has('company.id')) {
            return session()->get('company.id');
        } else {
            return null;
        }
    }

    /**
     * @return mixed|null
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    private function getCompanyLogo()
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
    private function getCompanyName()
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
    private function getCompany()
    {
        return Company::find($this->getCompanyId());
    }

    /**
     * @param string|int|array|\Spatie\Permission\Contracts\Role|\Illuminate\Support\Collection $role
     * @return bool
     */
    private function hasRole($role)
    {
        return Auth::user()->hasRole($role);
    }

}
