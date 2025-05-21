<?php

namespace App\Channel;

use ApiFeature\Notification\Core\Enums\NotificationTypeEnum;
use ApiFeature\Notification\Domain\Interfaces\NotificationChannelInterface;
use Google\Exception;
use Google_Client;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Notifications\Notification;


// this is for firebase notification
class FcmChannel implements NotificationChannelInterface
{

    /**
     * @throws GuzzleException
     * @throws Exception
     */


    public function send($notifiable, Notification $notification): \Psr\Http\Message\ResponseInterface
    {
        $message = $notification->toFcm($notifiable);
        $firebaseChannel = NotificationTypeEnum::Firebase->name;
        $client = new Client();
        return $client->post(config("notification.channels.$firebaseChannel.fcm_url"), [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->getAccessToken(),
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'message' => [
                    'token' => $message['to'],
                    'notification' => $message['notification'],
                    'data' => $message['data'] ?? null,
                ],
            ],
        ]);
    }


    /**
     * @throws Exception
     */


    private function getAccessToken()
    {
        $credentialsPath = config('notification.channels.firebase.service_account');  // Path to your service account file

        $client = new Google_Client(); // install composer require google/apiclient
        $client->setAuthConfig($credentialsPath);
        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');

        $token = $client->fetchAccessTokenWithAssertion();
        return $token['access_token'];
    }
}

