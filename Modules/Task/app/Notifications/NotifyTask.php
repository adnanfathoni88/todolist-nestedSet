<?php

namespace Modules\Task\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NotifyTask extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $task;
    public $date;

    public function __construct($task, $date)
    {
        $this->task = $task;
        $this->date = $date;
    }
    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Task Reminder')
            ->greeting('Hello ' . $notifiable->name)
            ->line('Kamu memiliki tugas baru yang harus diselesaikan')
            ->line('Task: ' . $this->task)
            ->line('Date: ' . $this->date)
            ->action('View Task', url('/login'))
            ->line('Terima Kasih');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable): array
    {
        return [
            'task' => $this->task,
            'date' => $this->date,
        ];
    }
}
