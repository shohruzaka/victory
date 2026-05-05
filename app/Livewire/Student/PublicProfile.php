<?php

namespace App\Livewire\Student;

use App\Models\User;
use App\Models\Duel;
use App\Models\Achievement;
use Livewire\Component;

class PublicProfile extends Component
{
    public User $user;

    public function mount($id)
    {
        $this->user = User::where('role', 'student')->findOrFail($id);
    }

    public function render()
    {
        $user = $this->user;
        
        $gameResults = $user->gameResults()
            ->latest()
            ->limit(5)
            ->get()
            ->map(function ($item) {
                return (object) [
                    'type' => 'solo',
                    'mode' => $item->mode,
                    'score' => $item->score,
                    'total_questions' => $item->total_questions,
                    'xp_earned' => $item->xp_earned,
                    'created_at' => $item->created_at,
                    'is_victory' => $item->score >= ($item->total_questions / 2),
                    'opponent_name' => null,
                    'is_draw' => false,
                ];
            });

        $duels = Duel::where(function($q) use ($user) {
                $q->where('player1_id', $user->id)
                  ->orWhere('player2_id', $user->id);
            })
            ->where('status', 'finished')
            ->with(['player1', 'player2'])
            ->latest()
            ->limit(5)
            ->get()
            ->map(function ($duel) use ($user) {
                $isPlayer1 = $duel->player1_id === $user->id;
                $myScore = $isPlayer1 ? $duel->p1_score : $duel->p2_score;
                $opponent = $isPlayer1 ? $duel->player2 : $duel->player1;
                
                $isVictory = $duel->winner_id === $user->id;
                $isDraw = $duel->winner_id === null;

                return (object) [
                    'type' => 'duel',
                    'mode' => 'PvP Duel',
                    'score' => $myScore,
                    'total_questions' => count($duel->question_ids),
                    'xp_earned' => $isVictory ? 200 : 0,
                    'created_at' => $duel->created_at,
                    'is_victory' => $isVictory,
                    'is_draw' => $isDraw,
                    'opponent_name' => $opponent ? $opponent->name : 'Unknown',
                ];
            });

        $recentLogs = collect($gameResults)->merge($duels)->sortByDesc('created_at')->take(5);

        $totalBattles = $user->gameResults()->count() + Duel::where(function($q) use ($user) {
            $q->where('player1_id', $user->id)->orWhere('player2_id', $user->id);
        })->where('status', 'finished')->count();

        $soloWins = $user->gameResults()->where('score', '>', 5)->count();
        $duelWins = Duel::where('winner_id', $user->id)->count();

        $winRate = $totalBattles > 0 
            ? round((($soloWins + $duelWins) / $totalBattles) * 100) 
            : 0;

        $allAchievements = Achievement::all();
        $userAchievements = $user->achievements()->pluck('achievement_id')->toArray();

        return view('livewire.student.public-profile', [
            'recentLogs' => $recentLogs,
            'totalBattles' => $totalBattles,
            'winRate' => $winRate,
            'allAchievements' => $allAchievements,
            'userAchievements' => $userAchievements,
        ])->layout('components.layouts.student');
    }
}
