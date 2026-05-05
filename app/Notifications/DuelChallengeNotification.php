<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class DuelChallengeNotification extends Notification
{
    use Queueable;

    public function __construct(public User $challenger, public string $duelUuid)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Incoming Challenge!',
            'message' => "{$this->challenger->name} has challenged you to a neural duel.",
            'icon' => 'heroicon-o-swords',
            'type' => 'duel_challenge',
            'duel_uuid' => $this->duelUuid,
            'challenger_name' => $this->challenger->name,
        ];
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}
