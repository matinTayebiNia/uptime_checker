<?php

namespace App\Broadcasting;

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
     */
    public function send($notifiable, Notification $notification)
    {
        if (!method_exists(Notification::class, "toSms")) {
            throw new \Exception("toSms method is not defined");
        }
        $data=$notification->toSms($notifiable);
        $phone=$data["phone"];
        $message=$data["message"];
        //todo sms ir package
        try {

        }catch (\Exception $exception){

        }
    }
}
