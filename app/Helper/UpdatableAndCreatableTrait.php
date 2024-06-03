<?php

namespace App\Helper;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

trait UpdatableAndCreatableTrait
{
    //
    //
    //
    public static function bootCreatable()
    {
        if (Auth::check()) {
            static::creating(function ($model)  {
                $model->created_by_id = Auth::user()->id;
            });

            static::updating(function ($model)  {
                $model->updated_by_id = Auth::user()->id;
            });
        }
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, "created_by_id", "id");
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, "updated_by_id", "id");
    }

}
