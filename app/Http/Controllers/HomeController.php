<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\GameResult;
use App\Models\Duel;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        // Get top 3 users
        $topUsers = User::where('role', 'student')
            ->orderByDesc('xp')
            ->limit(3)
            ->get();

        // Get recent activities
        $gameResults = GameResult::with('user')->latest()->limit(3)->get()->map(function($res) {
            return (object) [
                'user_name' => $res->user->name,
                'message' => "completed a {$res->mode} session",
                'time' => $res->created_at,
                'color' => 'bg-cyan-600'
            ];
        });

        $duels = Duel::where('status', 'finished')->with(['player1', 'player2'])->latest()->limit(3)->get()->map(function($duel) {
            $p1 = $duel->player1->name ?? 'User';
            $p2 = $duel->player2->name ?? 'User';
            return (object) [
                'user_name' => $p1,
                'message' => "won a Duel against {$p2}",
                'time' => $duel->updated_at,
                'color' => 'bg-fuchsia-600'
            ];
        });

        $activities = collect($gameResults)->merge($duels)->sortByDesc('time')->take(3);

        return view('welcome', [
            'topUsers' => $topUsers,
            'activities' => $activities
        ]);
    }
}
