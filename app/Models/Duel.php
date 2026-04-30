<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Duel extends Model
{
    /** @use HasFactory<\Database\Factories\DuelFactory> */
    use HasFactory;

    protected $fillable = [
        'uuid',
        'player1_id',
        'player2_id',
        'p1_score',
        'p2_score',
        'p1_current_index',
        'p2_current_index',
        'question_ids',
        'status',
        'winner_id',
    ];

    protected $casts = [
        'question_ids' => 'array',
    ];

    public function player1(): BelongsTo
    {
        return $this->belongsTo(User::class, 'player1_id');
    }

    public function player2(): BelongsTo
    {
        return $this->belongsTo(User::class, 'player2_id');
    }

    public function winner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'winner_id');
    }
}
