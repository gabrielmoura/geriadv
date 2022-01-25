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
        if (config('panel.forceCache')) {
            $userAuth = Auth::user();
            if (!$userAuth->hasRole('admin') && !session()->has('company.id')) session(['company.id' => $userAuth->employee()->first()->company()->first()->id]);
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
        if (config('panel.forceCache')) {
            return cache()->remember('company:' . $this->getCompanyId(), 60 * 60 * 12, function () {
                return Company::find($this->getCompanyId());
            });
        }

        return Company::find($this->getCompanyId());
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
        // Insere dados da empresa na sessão caso não seja admin.
        $userAuth = Auth::user();
        /*
         if(!$userAuth->hasRole('admin')){
             if (!session()->has('company.id')){
             session(['company'=>[
                 'id' => $userAuth->employee()->first()->company()->first()->id,
                 'name' => $userAuth->employee()->first()->company()->first()->name,
                 'logo' => $userAuth->employee()->first()->company()->first()->logo,
                 'banned' => $userAuth->employee()->first()->company()->first()->banned
                 ]]);
             }
         }
         */
        if (config('panel.forceCache')) {
            if (!session()->has('company.id') && !$userAuth->hasRole('admin')) session(['company.id' => $this->getCompany()->id]);
            if (!session()->has('company.name') && !$userAuth->hasRole('admin')) session(['company.name' => $this->getCompany()->name]);
            if (!session()->has('company.logo') && !$userAuth->hasRole('admin')) session(['company.logo' => $this->getCompany()->logo]);
            if (!session()->has('company.banned') && !$userAuth->hasRole('admin')) session(['company.banned' => $this->getCompany()->banned]);
        } else {
            if (!session()->has('company.id') && !$userAuth->hasRole('admin')) session(['company.id' => $userAuth->employee()->first()->company()->first()->id]);
            if (!session()->has('company.name') && !$userAuth->hasRole('admin')) session(['company.name' => $userAuth->employee()->first()->company()->first()->name]);
            if (!session()->has('company.logo') && !$userAuth->hasRole('admin')) session(['company.logo' => $userAuth->employee()->first()->company()->first()->logo]);
            if (!session()->has('company.banned') && !$userAuth->hasRole('admin')) session(['company.banned' => $userAuth->employee()->first()->company()->first()->banned]);
        }
    }

    /**
     * @return bool
     */
    public function hasBanned()
    {
        return session()->get('company.banned');
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
