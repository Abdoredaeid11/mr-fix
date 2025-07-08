<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Helpers\FirebaseHelper;

class NotificationController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'device_token' => 'required|string',
            'title' => 'required|string',
            'body' => 'required|string',
        ]);

        $response = FirebaseHelper::sendNotification(
            $request->device_token,
            $request->title,
            $request->body
        );

        return response()->json([
            'success' => true,
            'firebase_response' => json_decode($response, true)
        ]);
    }
}
