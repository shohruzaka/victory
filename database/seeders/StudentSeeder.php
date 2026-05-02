<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Bitta aniq test talabasi (login qilish uchun qulay)
        User::updateOrCreate(
            ['email' => 'student@quizarena.test'],
            [
                'name' => 'Test Talaba',
                'password' => Hash::make('password'),
                'group_name' => '211-21',
                'xp' => 1500,
                'level' => 2,
            ]
        );

        // 20 ta tasodifiy talaba
        User::factory(20)->create();
    }
}
