<?php

namespace App\Livewire\Student\Arena;

use App\Models\Duel;
use Livewire\Component;
use Livewire\WithPagination;

class DuelHistory extends Component
{
    use WithPagination;

    public function render()
    {
        $duels = Duel::where(function($query) {
                $query->where('player1_id', auth()->id())
                      ->orWhere('player2_id', auth()->id());
            })
            ->where('status', 'finished')
            ->with(['player1', 'player2', 'winner'])
            ->latest()
            ->paginate(10);

        return view('livewire.student.arena.duel-history', [
            'duels' => $duels
        ])->layout('components.layouts.student');
    }
}
