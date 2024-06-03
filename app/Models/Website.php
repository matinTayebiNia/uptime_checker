<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Website extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "url",
        "isHttps",
        "ping",
        "checked",
        "status"
    ];

    /**
     * getting info of user owner website
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
