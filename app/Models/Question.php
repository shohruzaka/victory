<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    /** @use HasFactory<\Database\Factories\QuestionFactory> */
    use HasFactory;

    protected $fillable = ['text', 'topic_id', 'difficulty', 'points'];

    protected static function boot()
    {
        parent::boot();

        // Savol o'chganida barcha variantlarni (options) ham o'chirib yuborish
        static::deleting(function ($question) {
            $question->options()->delete();
        });
    }

    /**
     * Get points based on difficulty.
     */
    public static function getPointsByDifficulty(string $difficulty): int
    {
        return match ($difficulty) {
            'easy' => 10,
            'medium' => 20,
            'hard' => 30,
            default => 10,
        };
    }

    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    public function options(): HasMany
    {
        return $this->hasMany(Option::class);
    }
}
