<?php

namespace App\Notifications;

use App\Models\Duel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class DuelFinishedNotification extends Notification
{
    use Queueable;

    public function __construct(public Duel $duel, public string $result)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray(object $notifiable): array
    {
        $opponent = $this->duel->player1_id === $notifiable->id ? $this->duel->player2 : $this->duel->player1;
        $opponentName = $opponent ? $opponent->name : 'Unknown';

        return [
            'title' => "Duel Finished: " . ucfirst($this->result),
            'message' => "Your match against {$opponentName} has concluded. Outcome: " . strtoupper($this->result),
            'icon' => 'heroicon-o-swords',
            'type' => 'duel',
            'duel_uuid' => $this->duel->uuid,
        ];
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}
