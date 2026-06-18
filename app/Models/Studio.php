<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Studio extends Model
{
    protected $fillable = [
        'studio_name',
        'capacity',
    ];

    public function seats()
    {
        return $this->hasMany(Seat::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}