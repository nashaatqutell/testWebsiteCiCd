<?php


use App\Channel\FcmChannel;
use App\Channel\PusherChannel;
use App\Enums\Notification\NotificationTypeEnum;

return [
    'default_channels' => [NotificationTypeEnum::Firebase->name], // Can be firebase or pusher

    'channels' => [
        NotificationTypeEnum::Firebase->name => [
            'enabled' => true,
            'fcm_url' => 'https://fcm.googleapis.com/v1/projects/kashfia-32651/messages:send',
            'service_account' => env('FIREBASE_SERVICE_ACCOUNT', public_path("service_account.json")),
            "class" => FcmChannel::class
        ],

        NotificationTypeEnum::Pusher->name => [
            'enabled' => true,
            'app_id' => env('PUSHER_APP_ID', "1950833"),
            'app_key' => env('PUSHER_APP_KEY', "640ef681bcaad9d89a8c"),
            'app_secret' => env('PUSHER_APP_SECRET', "97dff5165b0435104d2f"),
            'app_cluster' => env('PUSHER_APP_CLUSTER', "mt1"),
            "class" => PusherChannel::class
        ],
    ],
];
