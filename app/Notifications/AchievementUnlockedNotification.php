<?php

namespace App\Notifications;

use App\Models\Achievement;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AchievementUnlockedNotification extends Notification
{
    use Queueable;

    public function __construct(public Achievement $achievement)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'New Achievement Unlocked!',
            'message' => "Congratulations! You've earned the '{$this->achievement->name}' badge.",
            'icon' => $this->achievement->icon,
            'type' => 'achievement',
        ];
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'title' => 'New Achievement Unlocked!',
            'message' => "Congratulations! You've earned the '{$this->achievement->name}' badge.",
            'icon' => $this->achievement->icon,
            'type' => 'achievement',
        ]);
    }
}
