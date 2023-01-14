<?php

namespace App\Listeners;

use App\Events\SendSMSEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CartSubmittedListener implements ShouldQueue
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
     * @param  \App\Events\SendSMSEvent  $event
     * @return void
     */
    public function handle(SendSMSEvent $event): void
    {
        $event->sms->sendMessage($event->sender, $event->receptor, $event->message);
    }
}
