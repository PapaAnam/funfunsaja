<?php

namespace App\Listeners;

use App\Events\UpdatePhoneNumber;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmailActivationPhoneNumber
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UpdatePhoneNumber  $event
     * @return void
     */
    public function handle(UpdatePhoneNumber $event)
    {
        Mail::to($event->user->email)->send(new PhoneNumberEdited($event->user));
    }
}
