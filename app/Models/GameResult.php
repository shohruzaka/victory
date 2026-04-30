<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GameResult extends Model
{
    /** @use HasFactory<\Database\Factories\GameResultFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'mode',
        'category',
        'score',
        'total_questions',
        'xp_earned',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
