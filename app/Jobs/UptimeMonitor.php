<?php

namespace App\Jobs;

use App\Events\UptimeCheckFailed;
use App\Events\UptimeCheckSuccess;
use App\Models\Website;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class UptimeMonitor implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     * check website is up or not
     *
     * @throws ConnectionException
     */
    public function handle(): void
    {
        // each every website
        foreach ($this->getWebsites() as $uncheckedWebsite) {
            try {
                // checking  website status and update website detail
                $this->checkWebsiteIsUp($uncheckedWebsite);
            } catch (ConnectionException $exception) {
                //  update website detail and run failed event
                $this->runFailedEvent($uncheckedWebsite, $exception->getMessage());
            }
            $uncheckedWebsite->save();
        }
    }

    /**
     * getting data by date_check
     *
     * @return Collection|array
     */
    private function getWebsites(): Collection|array
    {
        // getting websites By Hourly Date Check
        return Website::getWebsitesByHourlyDateCheck()->get();
    }

    /**
     * check domain has ssl or not
     *
     * @param $domain
     * @return bool
     */
    public function hasSsl($domain): bool
    {
        try {
            $g = stream_context_create(array("ssl" => array("capture_peer_cert" => true)));
            $r = fopen($domain, "rb", false, $g);
            $result = false;
            $cont = stream_context_get_params($r);
            if (array_key_exists("peer_certificate", $cont["options"]["ssl"]))
                $result = openssl_x509_export($cont["options"]["ssl"]["peer_certificate"], $cert);
            fclose($r);
            return $result;
        } catch (\Exception $exception) {
            return false;
        }
    }

    /**
     * @param mixed $res
     * @return string
     */
    public function getPing(mixed $res): string
    {
        return round($res->handlerStats()["appconnect_time_us"] / 1000) . "ms";
    }

    /**
     * @param Website $uncheckedWebsite
     * @return void
     * @throws ConnectionException
     */
    public function checkWebsiteIsUp(Website $uncheckedWebsite): void
    {
        $res = Http::withoutVerifying()->get($uncheckedWebsite->url);
        if ($res->successful()) {
            $uncheckedWebsite->status = true;
            $uncheckedWebsite->ping = $this->getPing($res);
            // checking ssl domain
            $this->hasSsl($uncheckedWebsite->url) ?
                $uncheckedWebsite->isHttps = true :
                $uncheckedWebsite->isHttps = false;
            // dispatch UptimeCheckSuccess event for
            //  calling LogSuccess listener
            UptimeCheckSuccess::dispatch($uncheckedWebsite);
        }
    }

    /**
     * store detail of website to database and
     * call UptimeCheckFailed event
     *
     * @param Website $website
     * @param string $messageException
     * @return void
     */
    private function runFailedEvent(Website $website, string $messageException)
    {
        $website->status = false;
        $website->ping = "-1ms";
        $website->isHttps = false;
        // dispatch UptimeCheckFailed event for
        //  calling LogFailed and SendFailedMessage listener
        UptimeCheckFailed::dispatch($website, $messageException);
    }
}
