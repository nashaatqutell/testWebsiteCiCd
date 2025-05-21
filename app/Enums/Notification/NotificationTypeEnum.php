<?php

namespace App\Enums\Notification;

enum NotificationTypeEnum : int
{
    case Pusher = 1;

    case Firebase = 2;
}
