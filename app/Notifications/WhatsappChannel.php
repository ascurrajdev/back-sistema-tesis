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
        $notifiable->phone_number = str_replace("+","",$notifiable->phone_number);
        $notifiable->phone_number = str_replace(" ","",$notifiable->phone_number);
        $whatsappMessageOptions = $notification->toWhatsapp($notifiable)->to($notifiable->phone_number);
        $this->whatsappService->sendMessage($whatsappMessageOptions->toArray());
    }
}
