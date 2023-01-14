<?php

namespace App\Events;

use App\Services\SMS\SMSServiceInterface;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendSMSEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public SMSServiceInterface $sms;
    public function __construct(public string $sender,public string $receptor,public string $message)
    {

    }

}
