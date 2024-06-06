<?php

use App\Jobs\UptimeMonitor;
use Illuminate\Support\Facades\Schedule;
/*
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();*/

Schedule::job(UptimeMonitor::class)->hourly();
