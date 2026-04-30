<?php

namespace App\Livewire\Student;

use App\Models\User;
use Livewire\Component;

class Leaderboard extends Component
{
    public function render()
    {
        $topUsers = User::where('role', 'student')
            ->orderByDesc('xp')
            ->limit(20)
            ->get();

        return view('livewire.student.leaderboard', [
            'topUsers' => $topUsers
        ])->layout('components.layouts.student');
    }
}
