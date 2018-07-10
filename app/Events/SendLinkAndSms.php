<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SendLinkAndSms
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $sms_message;
    public $user;

    public function __construct($email_type, $user)
    {
        $this->sms_message      = $sms_message;
        $this->user             = $user;
    }    
}
