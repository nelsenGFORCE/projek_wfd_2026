<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    protected $fillable = [
        'transaction_id',
        'seat_id',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function seat()
    {
        return $this->belongsTo(Seat::class);
    }
}