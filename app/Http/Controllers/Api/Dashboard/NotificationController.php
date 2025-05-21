<?php

namespace App\Http\Controllers\Api\Dashboard;


use App\Factory\NotificationTypeFactory;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Service\Notification\NotificationService;
use App\Service\Notification\OrderShippedService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{

//    public function __construct(protected NotificationChannelInterface $channel){}

    // old code
//    public function send_notification(Request $request): JsonResponse
//    {
//        $notification_type = NotificationTypeFactory::getNotificationMethods($request->type ?? NotificationTypeEnum::Firebase->value);
//        Config::set("notification.default_channel",$notification_type);
//        $user = User::query()->whereId(1)->first();
//        $this->channel->send($user, new sendNotificationService());
//        return $this->successResponse("Notification sent successfully");
//    }

    // new code

    public function sendNotification(Request $request)
    {
        $user = auth("sanctum")->user();
        $notificationService = new NotificationService($request->methods ?? []);
        $notificationService->send($user, new OrderShippedService());
        return $this->successResponse("Notification sent successfully");
    }

}


