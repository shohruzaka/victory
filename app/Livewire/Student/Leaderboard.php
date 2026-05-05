<?php

namespace App\Livewire\Student;

use App\Models\User;
use App\Models\GameResult;
use Livewire\Component;

class Leaderboard extends Component
{
    public function render()
    {
        $topUsers = User::where('role', 'student')
            ->orderByDesc('xp')
            ->limit(20)
            ->get();

        // Hall of Fame: Rejimlar bo'yicha rekordlar
        $records = [
            'classic' => GameResult::where('mode', 'classic')
                ->with('user')
                ->orderByDesc('score')
                ->orderByDesc('xp_earned')
                ->first(),
                
            'survival' => GameResult::where('mode', 'survival')
                ->with('user')
                ->orderByDesc('score')
                ->first(),
                
            'speedrun' => GameResult::where('mode', 'speedrun')
                ->with('user')
                ->orderByDesc('xp_earned')
                ->first(),
        ];

        return view('livewire.student.leaderboard', [
            'topUsers' => $topUsers,
            'records' => $records
        ])->layout('components.layouts.student');
    }
}
