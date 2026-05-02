<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Topic extends Model
{
    /** @use HasFactory<\Database\Factories\TopicFactory> */
    use HasFactory;

    protected $fillable = ['subject_id', 'name', 'slug'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($topic) {
            if (! $topic->slug) {
                $topic->slug = Str::slug($topic->name);
            }
        });

        // Kaskad o'chirish: Mavzu o'chganda barcha savollari ham o'chib ketishi uchun
        static::deleting(function ($topic) {
            $topic->questions->each(function ($question) {
                $question->delete(); // Bu Question modelining o'z "deleting" hodisasini ham chaqiradi
            });
        });
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }
}
