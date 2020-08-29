<?php

namespace App\Listeners;

use App\Events\TriggerNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class TriggerNotificationListener implements ShouldQueue
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
     * @param  TriggerNotification  $event
     * @return void
     */
    public function handle(TriggerNotification $event)
    {
        $message = $event->message;
        if(isset($message->otp)) {
            $response = triggerOtpToUsers($message);
            \Log::info('SMS LOG:', [$response]);
        } elseif(isset($message->is_email)) {
            $response = triggerEmailToUsers($message);
            \Log::info('EMAIL LOG:', [$response]);
        } else {
            if(!isset($message->store_notification)) {
                $response = storeNotification($message);
                \Log::info('Store LOG:', [$response]);
            }
            $toIdArr = is_array($message->to_id) ? $message->to_id : [$message->to_id];
            if($message->from_id) {
                $pos = array_search((string)$message->from_id, $toIdArr);
                if ($pos !== false) {
                    unset($toIdArr[$pos]);
                }
            }
            if(count($toIdArr)) {
                $response = triggerNotificationToUsers($message, $toIdArr);
                \Log::info('Notification LOG:', [$response]);
            }
        }
        return $event;
    }

    /**
     * Handle a job failure.
     *
     * @param  \App\Events\TriggerNotification  $event
     * @param  \Exception  $exception
     * @return void
     */
    public function failed(TriggerNotification $event, $exception)
    {
        \Log::info('Event Failed:', ['event' => $event]);
    }
}
