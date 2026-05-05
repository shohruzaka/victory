<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    protected $fillable = ['name', 'description', 'icon', 'criteria_key'];

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
