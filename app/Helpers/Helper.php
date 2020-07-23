<?php

namespace App\Helpers;

use App\Models\Device;
use App\Models\Notification;
use App\Models\NotificationTemplate;
use GuzzleHttp\Client;

class Helper {
  public static function sendNotification($userId = null, $template = null) {
    // send push notification
    $devices = Device::where('user_id', $userId)
                ->get(['device_id'])
                ->pluck('device_id')
                ->toArray();

    $client = new Client();
    $res = $client->post(config('services.onesignal.api_url').'/notifications', [
      \GuzzleHttp\RequestOptions::JSON => [
        'app_id' => config('services.onesignal.app_id'),
        'include_player_ids' => $devices,
        'contents' => [
          'en' => $template->message_excerpt
        ],
        'headings' => [
          'en' => config('services.onesignal.notification_title')
        ],
      ]
    ]);
  }
}