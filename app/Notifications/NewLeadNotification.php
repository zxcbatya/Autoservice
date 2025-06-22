<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;

class NewLeadNotification extends Notification
{
    use Queueable;

    private array $data;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['telegram'];
    }

    /**
     * Get the Telegram representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \NotificationChannels\Telegram\TelegramMessage
     */
    public function toTelegram($notifiable)
    {
        $name = $this->data['name'];
        $phone = $this->data['phone'];
        $car = $this->data['car'] ?? 'не указан';
        $message = $this->data['message'];

        return TelegramMessage::create()
            ->to(env('TELEGRAM_CHAT_ID'))
            ->content(
                " заявка с сайта!**\n\n" .
                "**Имя:** {$name}\n" .
                "**Телефон:** `{$phone}`\n" .
                "**Автомобиль:** {$car}\n\n" .
                "**Сообщение:**\n{$message}"
            )
            ->options(['parse_mode' => 'Markdown']);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
