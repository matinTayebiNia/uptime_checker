<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UptimeSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        "app_name",
        'check_per_minute',
        "notification_type"
    ];
}
