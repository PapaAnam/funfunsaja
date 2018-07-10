<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\UserCreated' => [
            'App\Listeners\SendEmailVerification',
            'App\Listeners\SendToken',
        ],
        'App\Events\UpdatePhoneNumber' => [
            'App\Listeners\SendEmailActivationPhoneNumber',
            'App\Listeners\SendTokenToNewPhoneNumber',
        ],
        'App\Events\SendLinkAndSms'=>[
            'App\Listeners\SendSms',
            'App\Listeners\SendLink'
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
