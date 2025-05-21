<?php

namespace App\Service\Notification;

use Illuminate\Notifications\Notification;
class DefaultNotificationData extends Notification
{
    public function toFcm($notifiable): array
    {
        return [
            'to' => $notifiable->device_token, // Replace this with how you store the FCM token
            'notification' => [
                'title' => 'new Notification for you',
                'body' => 'please call supporter for more information',
            ],
            'data' => [
                "title" => "new Notification for you",
            ],
        ];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'source' => 'OrderNotification',
            'title' => 'OrderNotification',
            'description' => 'please check you order please',
            'image' => 'https://example.com/image.jpg',
            'notifiable_id' => $notifiable->id,
            'notifiable_type' => get_class($notifiable),
            'notification_type' => 1,
            'notification_status' => 1,
            'notification_method' => 1,
            'all_users' => false,
            'schedule_type' => 1,
            'schedule_date' => null,
            'schedule_time' => null,
            'repeat_type' => 1,
            'repeat_count' => 1,
        ];
    }


    public function toPusher($notifiable): array
    {
        return [
            'channel' => 'new Notification', // Channel name
            'event' => 'notification event', // Event name
            'data' => [
                'title' => 'notification title',
                'body' => 'new notification for you',
            ],
        ];
    }


}

