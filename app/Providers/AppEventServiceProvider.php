<?php

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Verified;
use App\Events\AccountRegistered;
use App\Listeners\AccountRegisterNotify;

use App\Events\EmailVerified;
use App\Listeners\EmailVerification;

class AppEventServiceProvider extends ServiceProvider {

    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        AccountRegistered::class => [
            AccountRegisterNotify::class
        ],
        EmailVerified::class => [
            EmailVerification::class
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

