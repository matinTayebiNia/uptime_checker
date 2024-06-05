<?php

namespace App\Models;

use App\Helper\UpdatableAndCreatableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static Builder getFromNowUntil2MinutesLater()
 * @method static Builder search()
 * @method static $this find(string $id)
 */
class Website extends Model
{
    use HasFactory, UpdatableAndCreatableTrait;

    protected $fillable = [
        "name",
        "url",
        "isHttps",
        "ping",
        "date_check",
        "status"
    ];

    public function getStatus(): string
    {
        return $this->status == true ? "up" : "down";
    }

    /**
     * this scope set some query on website resources by passing query strings in url
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeSearch(Builder $query): Builder
    {
        return
            //filter by date
            $query->when(
                $this->checkDateQueryStringsExists()
                , function (Builder $query) {
                return $query->where("created_at", '>=', request("date_start"))
                    ->where("created_at", '<=', request("date_end"));
            })
                //search with url or name
                ->when(request()->has("search"), function (Builder $query) {
                    $search = request("search");
                    return $query->where("url", "LIKE", "%{$search}%")
                        ->orWhere("name", "LIKE", "%{$search}%");
                })
                //filter by https
                ->when(request()->has("https"), function (Builder $query) {
                    return $query->where("https", request("https"));
                })
                //filter by status
                ->when(request()->has("status"), function (Builder $query) {
                    return $query->where("status", request("status"));
                });
    }

    /**
     * this method for checking date_start and date_end query string Exists in url or not
     * @return bool
     */
    public function checkDateQueryStringsExists(): bool
    {
        return request()->has("date_start") && request()->has("date_end");
    }

    public function scopeGetFromNowUntil2MinutesLater(Builder $q): Builder
    {
        return $q->where('date_check', "<=", now())
            ->where("date_check", ">=", now()->addMinutes(2));
    }
}
