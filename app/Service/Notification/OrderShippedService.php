<?php

namespace App\Service\Notification;

class OrderShippedService extends DefaultNotificationData
{

    protected ?array $data = [];

    public function __construct(?array $data = [])
    {
        $this->data = array_merge([
            'title' => 'Order Shipped',
            'body' => 'Your order has been shipped.',
        ], $data);
    }

    public function toFcm($notifiable): array
    {
        return [
            'to' => $notifiable->device_token, // Replace this with how you store the FCM token in your database
            'notification' => [
                'title' => $this->data['title'],
                'body' => $this->data['body'],
                'icon' => 'icon.png',
                'click_action' => 'https://example.com',
            ],
            'data' => [
                'title' => $this->data['title'],
                'body' => $this->data['body'],
                'icon' => 'icon.png',
                'click_action' => 'https://example.com',
                'type' => 'order_shipped',
            ],
        ];
    }

    public function toPusher($notifiable): array
    {
        return [
            'channel' => 'order_notifications', // Channel name
            'event' => 'order_shipped', // Event name
            'data' => [
                'title' => $this->data['title'],
                'body' => $this->data['body'],
                'order_id' => $this->data['order_id'] ?? '12345',
                'user_id' => $notifiable->id,
                'user_name' => $notifiable->name,
                'timestamp' => now()->toDateTimeString(),
            ],
        ];
    }

}
