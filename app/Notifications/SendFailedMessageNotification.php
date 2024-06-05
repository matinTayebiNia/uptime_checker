<?php

namespace App\Notifications;

use App\Broadcasting\SmsChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendFailedMessageNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private string $message;

    /**
     * Create a new notification instance.
     */
    public function __construct
    (private string $url, private string $errorMessage)
    {
        $this->message = "failed to load {$this->url}. \n error message:{$this->errorMessage}";
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return getSetting()->notification_type == "sms" ? [SmsChannel::class] : ["mail"];
    }

    public function toSms(object $notifiable): array
    {
        return [
            "message" => $this->message,
            "phone" => env("sms")
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line($this->message)
            ->line('Thank you for using our application!');
    }


}
