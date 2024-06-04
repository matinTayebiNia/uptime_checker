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
    use HasFactory, UpdatableAndCreatableTrait;

    protected $fillable = [
        "name",
        "url",
        "isHttps",
        "ping",
        "checked",
        "status"
    ];

    public function getStatus(): string
    {
        return $this->status == true ? "up" : "down";
    }
}
