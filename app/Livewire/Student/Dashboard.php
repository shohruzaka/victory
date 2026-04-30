<?php

namespace App\Livewire\Student;

use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $user = auth()->user();
        
        $recentLogs = $user->gameResults()
            ->latest()
            ->limit(5)
            ->get();

        $totalBattles = $user->gameResults()->count();
        $winRate = $totalBattles > 0 
            ? round(($user->gameResults()->where('score', '>', 0)->count() / $totalBattles) * 100) 
            : 0;

        return view('livewire.student.dashboard', [
            'recentLogs' => $recentLogs,
            'totalBattles' => $totalBattles,
            'winRate' => $winRate,
        ])->layout('components.layouts.student');
    }
}
