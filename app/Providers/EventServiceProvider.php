<?php

namespace App\Providers;

use App\Events\Client\BirthdayCustomerEvent;
use App\Events\Employee\AccessWrongTimeEvent;
use App\Listeners\Client\BirthdayCustomerListener;
use App\Listeners\Employee\AccessedAfterHours;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,

        ],
        BirthdayCustomerEvent::class => [
            BirthdayCustomerListener::class,
        ],
        AccessWrongTimeEvent::class => [
            AccessedAfterHours::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
