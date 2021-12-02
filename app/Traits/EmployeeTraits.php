<?php

namespace App\Traits;

use App\Models\User;

trait EmployeeTraits
{

    public static function bootEmployeeTraits(): void
    {
        static::updating(function ($model) {
            User::findOrFail($model->user_id)->update(['email' => $model->email]);
        });
    }

}
