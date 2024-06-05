<?php

namespace App\Listeners\UptimeSuccess;

use App\Events\UptimeCheckSuccess;
use Illuminate\Support\Facades\Log;

class LogSuccessFull
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
    public function handle(UptimeCheckSuccess $event): void
    {
        $website = $event->website;
        $message = "the {$website->url} checked successfully";
        Log::channel("uptime_success")->info($message, [
            "id" => $website->id,
            "isHttps" => $website->isHttps,
            "ping" => $website->ping,
        ]);
    }
}
