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
        $error = substr($this->errorMessage, 0, 300);
        $this->message = "failed to load {$this->url}. \n error message:{$error}";
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return $this->getChannelByNotificationType();
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

    /**
     * @return string[]
     */
    private function getChannelByNotificationType(): array
    {
        return env("NOTIFICATION_TYPE") == "sms" ? [SmsChannel::class] : ["mail"];
    }


}
