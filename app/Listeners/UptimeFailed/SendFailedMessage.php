<?php

namespace App\Listeners\UptimeFailed;

use App\Events\UptimeCheckFailed;
use App\Notifications\SendFailedMessageNotification;
use Illuminate\Support\Facades\Notification;

class SendFailedMessage
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UptimeCheckFailed $event): void
    {

        /*
         * in this case because we need just send one mail,
         * so we set mail in channel before call notification using 'route' method
         */
        Notification::route("mail",
            [env("EMAIL") => "error website:{$event->website->url}"])
            ->notify(new SendFailedMessageNotification($event->website->url, $event->errorMessage));
    }
}
