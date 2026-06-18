<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $fillable = [
        'title',
        'synopsis',
        'duration',
        'poster',
        'genre',
        'status',
    ];

    protected function casts(): array
    {
        return [];
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
