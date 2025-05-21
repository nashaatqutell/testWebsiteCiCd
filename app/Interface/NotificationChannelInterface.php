<?php

namespace App\Interface;

use Illuminate\Notifications\Notification;

interface NotificationChannelInterface
{
    public function send($notifiable, Notification $notification);
}
