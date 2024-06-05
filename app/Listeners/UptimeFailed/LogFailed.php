<?php

namespace App\Listeners\UptimeFailed;

use App\Events\UptimeCheckFailed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class LogFailed
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
        $website = $event->website;
        Log::channel("uptime_failed")->error("failed to load {$website->url}", [
            "status" => $website->getStatus(),
            "errorMessage" => $event->errorMessage
        ]);
    }
}
