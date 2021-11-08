<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use NotificationChannels\WebPush\HasPushSubscriptions;
use Spatie\Permission\Traits\HasRoles;

class UserTenant extends Authenticatable
{
    //protected $connection = 'tenant';
    protected $table = 'users';
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
    use  HasPushSubscriptions;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return string
     */
    public function avatar()
    {
        return $this->avatar ?? "https://ui-avatars.com/api/?rounded=true&name=" . $this->name;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function social()
    {
        return $this->hasMany(UserSocial::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'id', 'user_id');

    }

}
