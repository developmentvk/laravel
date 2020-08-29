<?php

namespace App\Listeners;

use App\Events\SocketEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SocketEventListener implements ShouldQueue
{
    use InteractsWithQueue;

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
     * @param  SocketEvent  $event
     * @return void
     */
    public function handle(SocketEvent $event)
    {
        \Log::info('Event Emitted', [$event]);
    }
}
