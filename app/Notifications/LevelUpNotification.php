<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class LevelUpNotification extends Notification
{
    use Queueable;

    public function __construct(public int $newLevel)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Level Up!',
            'message' => "Neural sync increased! You have reached Level {$this->newLevel}.",
            'icon' => 'heroicon-o-arrow-trending-up',
            'type' => 'level_up',
        ];
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'title' => 'Level Up!',
            'message' => "Neural sync increased! You have reached Level {$this->newLevel}.",
            'icon' => 'heroicon-o-arrow-trending-up',
            'type' => 'level_up',
        ]);
    }
}
