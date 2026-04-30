<?php

namespace App\Events;

use App\Models\Duel;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MatchFound implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Duel $duel)
    {
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('matchmaking.' . $this->duel->player1_id),
            new PrivateChannel('matchmaking.' . $this->duel->player2_id),
        ];
    }
}
