<?php

namespace App\Service\Notification;


use App\Factory\NotificationTypeFactory;
use App\Interface\NotificationChannelInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NotificationService extends Notification
{
    use Queueable;

    protected ?array $methods = [];
    protected ?array $channels =[];
    public function __construct(?array $methods = [])
    {
        $this->channels = NotificationTypeFactory::getNotificationMethods($methods);
    }

    public function via($notifiable): array
    {
        return array_merge($this->channels,['database']);
    }

    public function send($notifiable,Notification $notification): void
    {
        $channels = $this->channels;
        foreach ($channels as $channel) {
            $channelClass = config("notification.channels.$channel.class");
            if (class_exists($channelClass) && is_subclass_of($channelClass, NotificationChannelInterface::class)) {
                app($channelClass)->send($notifiable, $notification);
            }
        }
    }
}
