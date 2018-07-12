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

    public $email_type;
    public $user;

    public function __construct($email_type, $user)
    {
        $this->email_type      = $email_type;
        $this->user             = $user;
    }    
}
