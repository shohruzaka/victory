<?php

use App\Http\Controllers\Auth\SocialController;
use App\Http\Controllers\HomeController;
use App\Livewire\Admin\Questions\Form;
use App\Livewire\Admin\Questions\Import;
use App\Livewire\Admin\Questions\Statistics;
use App\Livewire\Admin\Subjects\Index;
use App\Livewire\Student\Arena\Classic;
use App\Livewire\Student\Arena\DuelGame;
use App\Livewire\Student\Arena\DuelHistory;
use App\Livewire\Student\Arena\DuelLobby;
use App\Livewire\Student\Arena\Setup;
use App\Livewire\Student\Arena\SpeedRun;
use App\Livewire\Student\Arena\Survival;
use App\Livewire\Student\Dashboard;
use App\Livewire\Student\Leaderboard;
use App\Livewire\Student\PublicProfile;
use App\Livewire\Student\Settings;
use App\Livewire\Student\Subjects\Show;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'throttle:arena'])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/settings', Settings::class)->name('settings');
    Route::get('/leaderboard', Leaderboard::class)->name('leaderboard');

    // Subjects & Articles
    Route::get('/subjects', App\Livewire\Student\Subjects\Index::class)->name('subjects.index');
    Route::get('/subjects/{subject:slug}', Show::class)->name('subjects.show');
    Route::get('/library', App\Livewire\Student\Articles\Index::class)->name('articles.index');
    Route::get('/articles/{article:slug}', App\Livewire\Student\Articles\Show::class)->name('articles.show');

    Route::get('/arena/setup/{mode}', Setup::class)->name('arena.setup');
    Route::get('/arena/classic', Classic::class)->name('arena.classic');
    Route::get('/arena/speedrun', SpeedRun::class)->name('arena.speedrun');
    Route::get('/arena/survival', Survival::class)->name('arena.survival');
    Route::get('/arena/duel', DuelLobby::class)->name('arena.duel.lobby');
    Route::get('/arena/duel/history', DuelHistory::class)->name('arena.duel.history');
    Route::get('/arena/duel/{uuid}', DuelGame::class)->name('arena.duel');
    Route::get('/profile/{id}', PublicProfile::class)->name('profile.public');
});

Route::middleware(['auth', 'admin', 'throttle:admin'])->group(function () {
    Route::get('/admin', App\Livewire\Admin\Dashboard::class)->name('admin.dashboard');
    Route::get('/admin/settings', App\Livewire\Admin\Settings::class)->name('admin.settings');
    Route::get('/admin/subjects', Index::class)->name('admin.subjects.index');
    Route::get('/admin/students', App\Livewire\Admin\Users\Index::class)->name('admin.users.index');
    Route::get('/admin/questions', App\Livewire\Admin\Questions\Index::class)->name('admin.questions.index');
    Route::get('/admin/questions/statistics', Statistics::class)->name('admin.questions.statistics');
    Route::get('/admin/questions/create', Form::class)->name('admin.questions.create');
    Route::get('/admin/questions/import', Import::class)->name('admin.questions.import');
    Route::get('/admin/questions/{question}/edit', Form::class)->name('admin.questions.edit');

    // Articles
    Route::get('/admin/articles', App\Livewire\Admin\Articles\Index::class)->name('admin.articles.index');
    Route::get('/admin/articles/create', App\Livewire\Admin\Articles\Form::class)->name('admin.articles.create');
    Route::get('/admin/articles/{article}/edit', App\Livewire\Admin\Articles\Form::class)->name('admin.articles.edit');
});

Route::get('/auth/{provider}/redirect', [SocialController::class, 'redirect'])->name('social.redirect');
Route::get('/auth/{provider}/callback', [SocialController::class, 'callback'])->name('social.callback');
