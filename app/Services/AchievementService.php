<?php

namespace App\Services;

use App\Models\Achievement;
use App\Models\Duel;
use App\Models\GameResult;
use App\Models\User;
use App\Notifications\AchievementUnlockedNotification;

class AchievementService
{
    public static function check(User $user)
    {
        $unlocked = [];
        $lockedAchievements = Achievement::whereDoesntHave('users', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->get();

        foreach ($lockedAchievements as $achievement) {
            if (self::meetsCriteria($user, $achievement->criteria_key)) {
                $user->achievements()->attach($achievement->id);
                $user->notify(new AchievementUnlockedNotification($achievement));
                $unlocked[] = $achievement;
            }
        }

        return $unlocked;
    }

    protected static function meetsCriteria(User $user, string $criteriaKey): bool
    {
        switch ($criteriaKey) {
            case 'first_game':
                return $user->gameResults()->exists() || 
                       Duel::where('player1_id', $user->id)->orWhere('player2_id', $user->id)->exists();

            case 'flawless_classic':
                return $user->gameResults()
                    ->where('mode', 'classic')
                    ->whereRaw('score = total_questions')
                    ->where('total_questions', '>=', 10)
                    ->exists();

            case 'survival_expert':
                return $user->gameResults()
                    ->where('mode', 'survival')
                    ->where('score', '>=', 15)
                    ->exists();

            case 'speed_demon':
                return $user->gameResults()
                    ->where('mode', 'speedrun')
                    ->whereRaw('xp_earned - (score * 10) >= 150') // Approximation of speed bonus
                    ->exists();

            case 'duel_master':
                return Duel::where('winner_id', $user->id)->count() >= 5;

            default:
                return false;
        }
    }
}
