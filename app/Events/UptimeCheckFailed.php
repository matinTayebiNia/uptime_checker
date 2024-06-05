<?php

namespace App\Events;

use App\Models\Website;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UptimeCheckFailed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     * This class is called when a website request has failed
     */
    public function __construct
    (public Website $website, public string $errorMessage)
    {

    }
}
