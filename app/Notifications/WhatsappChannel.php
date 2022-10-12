<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use App\Services\WhatsappService;

class WhatsappChannel
{
    private $whatsappService;

    public function __construct()
    {
        $this->whatsappService = new WhatsappService;   
    }
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $whatsappMessageOptions = $notification->toWhatsapp($notifiable)->to($notifiable->phone_number);
        $this->whatsappService->sendMessage($whatsappMessageOptions->toArray());
    }
}
