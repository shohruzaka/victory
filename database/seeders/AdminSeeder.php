<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'tshohruz@gmail.com'],
            [
                'name' => 'Shohruz Admin',
                'password' => Hash::make('dotcent.2233'),
                'role' => UserRole::ADMIN,
            ]
        );
    }
}
