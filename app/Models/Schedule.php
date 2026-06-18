<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'movie_id',
        'studio_id',
        'show_date',
        'start_time',
        'ticket_price',
    ];

    protected function casts(): array
    {
        return [
            'show_date' => 'date',
            'ticket_price' => 'decimal:2',
        ];
    }

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    public function studio()
    {
        return $this->belongsTo(Studio::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
