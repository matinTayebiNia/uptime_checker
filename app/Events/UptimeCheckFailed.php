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
     */
    public function __construct
    (public Website $website, public string $errorMessage)
    {

    }
}
