<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ProviderResponseNotification extends Notification
{
    use Queueable;

    protected $request, $status;

    public function __construct($request, $status)
    {
        $this->request = $request;
        $this->status = $status;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'رد على الطلب',
            'message' => 'المستخدم ' . $this->request->provider->first_name.
                         ' قام بـ ' . ($this->status === 'accepted' ? 'قبول' : 'رفض') . ' طلبك',
            'request_id' => $this->request->id,
            'status' => $this->status,
        ];
    }
}
