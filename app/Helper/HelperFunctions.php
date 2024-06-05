<?php

use App\Models\UptimeSetting;

if (!function_exists("getSetting")) {

    function getSetting()
    {
        return UptimeSetting::first();
    }

}
