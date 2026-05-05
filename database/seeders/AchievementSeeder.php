<?php

namespace Database\Seeders;

use App\Models\Achievement;
use Illuminate\Database\Seeder;

class AchievementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $achievements = [
            [
                'name' => 'First Blood',
                'description' => 'Tizimda o\'tkazilgan birinchi o\'yin.',
                'icon' => 'heroicon-o-fire',
                'criteria_key' => 'first_game',
            ],
            [
                'name' => 'Flawless Victory',
                'description' => 'Classic rejimida 10 ta savolning barchasiga to\'g\'ri javob berish.',
                'icon' => 'heroicon-o-trophy',
                'criteria_key' => 'flawless_classic',
            ],
            [
                'name' => 'Survival Expert',
                'description' => 'Survival rejimida 15 tadan ko\'p savolga to\'g\'ri javob berish.',
                'icon' => 'heroicon-o-shield-check',
                'criteria_key' => 'survival_expert',
            ],
            [
                'name' => 'Speed Demon',
                'description' => 'SpeedRun rejimida 150 dan ortiq XP bonus yig\'ish.',
                'icon' => 'heroicon-o-bolt',
                'criteria_key' => 'speed_demon',
            ],
            [
                'name' => 'Duel Master',
                'description' => 'PvP duellarda jami 5 marta g\'alaba qozonish.',
                'icon' => 'heroicon-o-academic-cap',
                'criteria_key' => 'duel_master',
            ],
        ];

        foreach ($achievements as $achievement) {
            Achievement::updateOrCreate(
                ['criteria_key' => $achievement['criteria_key']],
                $achievement
            );
        }
    }
}
