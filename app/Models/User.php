<?php

namespace App\Models;

use App\Enums\UserRole;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'avatar',
        'group_name',
        'email',
        'password',
        'role',
        'xp',
        'level',
        'github_id',
        'github_token',
        'github_refresh_token',
        'google_id',
    ];

    /**
     * Get the user's avatar URL.
     */
    public function getAvatarUrlAttribute(): string
    {
        return $this->avatar 
            ? asset('storage/' . $this->avatar) 
            : 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=06b6d4&background=0f172a';
    }

    /**
     * Get the player's rank title.
     */
    public function getRankAttribute(): string
    {
        return match (true) {
            $this->xp >= 10000 => 'Grandmaster',
            $this->xp >= 5000 => 'Elite',
            $this->xp >= 2000 => 'Pro',
            $this->xp >= 500 => 'Advanced',
            default => 'Rookie',
        };
    }

    /**
     * Check if user is admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === UserRole::ADMIN;
    }

    /**
     * Check if user is student.
     */
    public function isStudent(): bool
    {
        return $this->role === UserRole::STUDENT;
    }

    /**
     * Get the game results for the user.
     */
    public function gameResults(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(GameResult::class);
    }

    public function achievements(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Achievement::class)->withTimestamps();
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class,
            'github_token' => 'encrypted',
            'github_refresh_token' => 'encrypted',
        ];
    }
}
