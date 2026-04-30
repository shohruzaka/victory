<?php

use App\Http\Controllers\Auth\SocialController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', \App\Livewire\Student\Dashboard::class)->name('dashboard');
    Route::get('/settings', \App\Livewire\Student\Settings::class)->name('settings');
    Route::get('/leaderboard', \App\Livewire\Student\Leaderboard::class)->name('leaderboard');
    Route::get('/arena/setup/{mode}', \App\Livewire\Student\Arena\Setup::class)->name('arena.setup');
    Route::get('/arena/classic', \App\Livewire\Student\Arena\Classic::class)->name('arena.classic');
    Route::get('/arena/speedrun', \App\Livewire\Student\Arena\SpeedRun::class)->name('arena.speedrun');
    Route::get('/arena/survival', \App\Livewire\Student\Arena\Survival::class)->name('arena.survival');
    Route::get('/arena/duel', \App\Livewire\Student\Arena\DuelLobby::class)->name('arena.duel.lobby');
    Route::get('/arena/duel/{uuid}', \App\Livewire\Student\Arena\DuelGame::class)->name('arena.duel');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', \App\Livewire\Admin\Dashboard::class)->name('admin.dashboard');
    Route::get('/admin/subjects', \App\Livewire\Admin\Subjects\Index::class)->name('admin.subjects.index');
    Route::get('/admin/questions', \App\Livewire\Admin\Questions\Index::class)->name('admin.questions.index');
    Route::get('/admin/questions/create', \App\Livewire\Admin\Questions\Form::class)->name('admin.questions.create');
    Route::get('/admin/questions/import', \App\Livewire\Admin\Questions\Import::class)->name('admin.questions.import');
    Route::get('/admin/questions/{question}/edit', \App\Livewire\Admin\Questions\Form::class)->name('admin.questions.edit');
});

Route::get('/auth/{provider}/redirect', [SocialController::class, 'redirect'])->name('social.redirect');
Route::get('/auth/{provider}/callback', [SocialController::class, 'callback'])->name('social.callback');
