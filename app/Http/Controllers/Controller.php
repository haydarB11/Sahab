<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;


    public function sendPushNotification($fcmtoken,$target_id, $title, $body,$link)
    {

        $credentialsFilePath = 'sahab-62d2e-firebase-adminsdk-n3p0j-603ee4ecd5.json';
        $client = new \Google_Client();
        $client->setAuthConfig($credentialsFilePath);
        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
        $apiurl = 'https://fcm.googleapis.com/v1/projects/sahab-62d2e/messages:send';
        $client->refreshTokenWithAssertion();
        $token = $client->getAccessToken();
        $access_token = $token['access_token'];

        $headers = [
            "Authorization: Bearer $access_token",
            'Content-Type: application/json'
        ];
        $test_data = [
            "title" => $title,
            "body" => $body,
            "link" => $link,
        ];

        $data['data'] =  $test_data;

        $data['token'] = $fcmtoken; // Retrive fcm_token from users table

        $payload['message'] = $data;
        $payload = json_encode($payload);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiurl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_exec($ch);
        $res = curl_close($ch);

        DB::table('notifications')->insert([
            "type" => $title,
            "data" => $body,
            "notifiable_id"=> $target_id,
            "notifiable_type"=> "admin",
            "link"=>$link,
            "created_at"=> Carbon::now(),
        ]);
        if ($res) {
            return response()->json([
                'message' => 'Notification has been Sent'
            ]);
        }
    }
}
