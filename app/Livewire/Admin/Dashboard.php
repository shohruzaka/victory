<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\GameResult;
use App\Models\Duel;
use App\Models\Question;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.admin.dashboard')
            ->layout('components.layouts.admin');
    }

    public function getStatsProperty()
    {
        return [
            'totalStudents' => User::where('role', 'student')->count(),
            'totalAdmins' => User::where('role', 'admin')->count(),
            'totalGames' => GameResult::count(),
            'avgScore' => round(GameResult::avg('score') ?? 0, 1),
            'totalDuels' => Duel::where('status', 'finished')->count(),
        ];
    }

    public function getActivitiesProperty()
    {
        $newUsers = User::where('role', 'student')->latest()->limit(3)->get()->map(function($user) {
            return [
                'type' => 'user',
                'message' => "Yangi talaba ro'yxatdan o'tdi: <span class='text-cyan-600 dark:text-cyan-400 font-medium'>{$user->name}</span>",
                'time' => $user->created_at,
                'color' => 'bg-cyan-600 dark:bg-cyan-500'
            ];
        });

        $recentDuels = Duel::where('status', 'finished')->with(['player1', 'player2'])->latest()->limit(3)->get()->map(function($duel) {
            $p1 = $duel->player1->name ?? 'User';
            $p2 = $duel->player2->name ?? 'User';
            return [
                'type' => 'duel',
                'message' => "Duel yakunlandi: <span class='text-fuchsia-600 dark:text-fuchsia-400 font-medium'>{$p1} VS {$p2}</span>",
                'time' => $duel->updated_at,
                'color' => 'bg-fuchsia-600 dark:bg-fuchsia-500'
            ];
        });

        $newQuestions = Question::latest()->limit(3)->get()->map(function($q) {
            $text = \Illuminate\Support\Str::limit($q->text, 30);
            return [
                'type' => 'question',
                'message' => "Yangi savol qo'shildi: <span class='text-emerald-600 dark:text-emerald-400 font-medium'>\"{$text}\"</span>",
                'time' => $q->created_at,
                'color' => 'bg-emerald-600 dark:bg-emerald-500'
            ];
        });

        return collect($newUsers)->merge($recentDuels)->merge($newQuestions)->sortByDesc('time')->take(6);
    }

    public function getSystemStatusProperty()
    {
        $totalQuestions = Question::count();
        if ($totalQuestions === 0) return ['hard' => 0, 'easy' => 0];

        $hardCount = Question::where('difficulty', 'hard')->count();
        $easyCount = Question::where('difficulty', 'easy')->count();

        return [
            'hard_percent' => round(($hardCount / $totalQuestions) * 100),
            'easy_percent' => round(($easyCount / $totalQuestions) * 100),
        ];
    }
}
