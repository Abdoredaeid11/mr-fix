<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewRequestNotification extends Notification
{
    use Queueable;

    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'طلب خدمة جديد',
            'message' => 'المستخدم ' . $this->request->client->first_name . ' طلب منك خدمة',
            'request_id' => $this->request->id,
            'client_id' => $this->request->client_id,
        ];
    }
}
