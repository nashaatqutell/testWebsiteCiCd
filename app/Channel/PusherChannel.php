<?php

namespace App\Channel;

use App\Enums\Notification\NotificationTypeEnum;
use App\Interface\NotificationChannelInterface;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Pusher\ApiErrorException;
use Pusher\Pusher;
use Pusher\PusherException;

// this is for pusher notification
class PusherChannel implements NotificationChannelInterface
{
    /**
     * @throws PusherException
     * @throws GuzzleException
     * @throws ApiErrorException
     */

    public function send($notifiable, Notification $notification): void
    {
        if (!class_exists(Pusher::class)) {
            Log::error('Pusher package is not installed. Please run `composer require pusher/pusher-php-server`.');
            return; // Gracefully exit if Pusher is not installed
        }

        $message = $notification->toPusher($notifiable);
        $pusherChannel = NotificationTypeEnum::Pusher->name;

        $pusher = new Pusher(
            config("notification.channels.$pusherChannel.app_key"),
            config("notification.channels.$pusherChannel.app_secret"),
            config("notification.channels.$pusherChannel.app_id"),
            [
                'cluster' => config("notification.channels.$pusherChannel.app_cluster"),
                'useTLS' => true,
            ]
        );

        // Send the notification via Pusher (using the channel and message format you desire)
        $pusher->trigger($message['channel'], $message['event'], $message['data']);
    }
}
