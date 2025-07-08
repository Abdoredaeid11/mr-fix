<?php

namespace App\Helpers;

use Google\Client;

class FirebaseHelper
{
    public static function getAccessToken()
    {

        $client = new Client();
        $client->setAuthConfig(storage_path('app/firebase/firebase-service-account.json'));
        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');

        $token = $client->fetchAccessTokenWithAssertion();
        return $token['access_token'];
        
    }

    public static function sendNotification($deviceToken, $title, $body)
    {
        $accessToken = self::getAccessToken();

$url = 'https://fcm.googleapis.com/v1/projects/mr-fix-c3f03/messages:send';

        $headers = [
            'Authorization: Bearer ' . $accessToken,
            'Content-Type: application/json',
        ];

        $message = [
            'message' => [
                'token' => $deviceToken,
                'notification' => [
                    'title' => $title,
                    'body' => $body,
                ],
            ]
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($message));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }
}
