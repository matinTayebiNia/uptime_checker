<?php

namespace App\Models;

use App\Helper\UpdatableAndCreatableTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static Builder getWebsitesByHourlyDateCheck()
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
     * @throws \Exception
     */
    public function scopeSearch(Builder $query): Builder
    {
        return
            //filter by date_check
            $query->when(
                $this->checkDateQueryStringsExists()
                , function (Builder $query) {

                // convert value of query strings to (h:00) format date
                list($dateStart, $dateEnd) = $this->convertToTimeFormatDate();

                // return date_check column  between date_start and date_end query
                return $query->whereTime("date_check", '>=', $dateStart)
                    ->whereTime("date_check", '<=', $dateEnd);
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

    public function scopeGetWebsitesByHourlyDateCheck(Builder $q): Builder
    {
        $now = now()->format("h:00");
        return $q->where('date_check', "LIKE", "%{$now}%");
    }

    /**
     * convert to h:00 format date
     *
     * @return array
     * @throws \Exception
     */
    private function convertToTimeFormatDate(): array
    {
        try {
            $dateStart = Carbon::createFromFormat("h:00", request("date_start"));
            $dateEnd = Carbon::createFromFormat("h:00", request("date_end"));
            return array($dateStart, $dateEnd);
        } catch (\Exception $exception) {
            throw new $exception;
        }
    }

    public function getFormatDateCheck(): string
    {
        return Carbon::parse($this->date_check)->format("H:i");
    }
}
