<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'schedule_id',
        'total_price',
        'payment_status',
        'midtrans_booking_code',
    ];

    protected function casts(): array
    {
        return [
            'total_price' => 'decimal:2',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($transaction) {
            if (empty($transaction->midtrans_booking_code)) {
                $transaction->midtrans_booking_code = 'TRX-' . strtoupper(Str::random(10));
            }
        });
    }
}