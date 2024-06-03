<?php

namespace App\Models;

use App\Helper\UpdatableAndCreatableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static Builder where(string $column, $op)
 */
class Website extends Model
{
    use HasFactory,UpdatableAndCreatableTrait;

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
