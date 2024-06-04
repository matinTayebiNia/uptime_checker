<?php

namespace App\Broadcasting;

use Cryptommer\Smsir\Classes\Smsir;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Notifications\Notification;

class SmsChannel
{
    /**
     * Create a new channel instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * send sms the channel.
     * @throws \Exception
     * @throws GuzzleException
     */
    public function send($notifiable, Notification $notification)
    {
        if (!method_exists(Notification::class, "toSms")) {
            throw new \Exception("toSms method is not defined");
        }

        $data = $notification->toSms($notifiable);
        $phone = $data["phone"];
        $message = $data["message"];

        $lineNumber = config("services.smsIr.line_number");
        $apiKey = config("services.smsIr.api_key");
        $smsIr = new Smsir($lineNumber, $apiKey);
        $smsIr->Send()->Bulk($message, [$phone]);

    }
}
