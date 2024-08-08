<?php

namespace App\Http\Controllers;

use App\Models\DeviceToken;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class pushNotificationController extends Controller
{
    public function pushNotification() {
        $title = 'title';
        $body = 'body';
        $url = 'https://fcm.googleapis.com/fcm/send';
        $serverKey = 'AAAA0FMLOcg:APA91bE3ZnLsY5JQPTx9qDghvzR8GjzlRbZazhDhO_AQiJvVZNjBRi5tpgBodyJ0L7YVFkY6Io3oyAmnZPHwq04Dj9KsiIKwv6r-xlv_k_ReP9hI3ygdL7h_gT7WQ0ezW_FLL19Iu1DS';
        $tokens = DeviceToken::where('is_allowed', true)->pluck('token')->toArray();

        $data =  [
            "registration_ids" => $tokens,
            "notification"=>[
                "title" => $title,
                "body" => htmlspecialchars(trim(strip_tags($body))),
                "sound" => "default"
            ]

        ];
        $encodedData = json_encode($data);

        $headers = [
            'Authorization:key=' . $serverKey,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);

        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }

        curl_close($ch);
        return response()->json([
            'notification sent'
        ], Response::HTTP_OK);
    }

    public function pushNotificationForSpecificUser($title, $body, $userId) {
        $title = $title;
        $body = $body;
        $url = 'https://fcm.googleapis.com/fcm/send';
        $serverKey = 'AAAA0FMLOcg:APA91bE3ZnLsY5JQPTx9qDghvzR8GjzlRbZazhDhO_AQiJvVZNjBRi5tpgBodyJ0L7YVFkY6Io3oyAmnZPHwq04Dj9KsiIKwv6r-xlv_k_ReP9hI3ygdL7h_gT7WQ0ezW_FLL19Iu1DS';
        $tokens = DeviceToken::where('is_allowed', true)->where('user_id', $userId)->pluck('token')->toArray();

        $data =  [
            "registration_ids" => $tokens,
            "notification"=>[
                "title" => $title,
                "body" => htmlspecialchars(trim(strip_tags($body))),
                "sound" => "default"
            ]

        ];
        $encodedData = json_encode($data);

        $headers = [
            'Authorization:key=' . $serverKey,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);

        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }

        curl_close($ch);
        return response()->json([
            'notification sent'
        ], Response::HTTP_OK);
    }

    public function pushNotificationTopic($request) {
        $title = $request->title;
        $body = $request->body;
        $topic = $request->topic;
        $url = 'https://fcm.googleapis.com/fcm/send';
        $serverKey = 'AAAA0FMLOcg:APA91bE3ZnLsY5JQPTx9qDghvzR8GjzlRbZazhDhO_AQiJvVZNjBRi5tpgBodyJ0L7YVFkY6Io3oyAmnZPHwq04Dj9KsiIKwv6r-xlv_k_ReP9hI3ygdL7h_gT7WQ0ezW_FLL19Iu1DS';
        $tokens = DeviceToken::where('is_allowed', true)->pluck('token')->toArray();

        $data =  [
            "to" => "/topics/$topic",
            "notification"=>[
                "title" => $title,
                "body" => htmlspecialchars(trim(strip_tags($body))),
                "sound" => "default"
            ]

        ];
        $encodedData = json_encode($data);

        $headers = [
            'Authorization:key=' . $serverKey,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);

        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }

        curl_close($ch);
        return response()->json([
            'notification sent'
        ], Response::HTTP_OK);
    }
}
