<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Models\User;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Illuminate\Support\Facades\Cache;

class CacheUserProvider extends EloquentUserProvider
{

    /**
     * CacheUserProvider constructor.
     * @param HasherContract $hasher
     */
    public function __construct(HasherContract $hasher)
    {
        parent::__construct($hasher, User::class);
    }

    /**
     * @param mixed $identifier
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveById($identifier)
    {
        return Cache::remember("user.$identifier", 60 * 60, function () use ($identifier) {
            return parent::retrieveById($identifier);
        });
//        return Cache::get("user.$identifier") ?? parent::retrieveById($identifier);
    }

}
