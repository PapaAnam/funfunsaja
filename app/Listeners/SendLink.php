<?php

namespace App\Listeners;

use App\Events\SendLinkAndSms;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\SendLink;

class SendLink
{

    public function handle(SendLinkAndSms $event)
    {
        Mail::to($event->user->email)->send(new SendLink($event->user, $event->email_type));
    }
}
