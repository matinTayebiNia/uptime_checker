<?php

namespace App\Notifications;

use App\Broadcasting\SmsChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendFailedMessageNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return getSetting()->notification_type == "sms" ? [SmsChannel::class] : ["email"];
    }

    public function toSms(object $notifiable): array
    {
        //todo create  message text
        return [
            "message" => '',
            "phone" => env("SMS")
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->line('Thank you for using our application!');
    }


}
