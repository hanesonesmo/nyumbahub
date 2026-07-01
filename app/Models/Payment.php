<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subscription_id',
        'transaction_reference',
        'gateway_transaction_id',
        'payment_provider',
        'amount',
        'currency',
        'payment_status',
        'payment_method',
        'callback_response',
        'paid_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'callback_response' => 'array',
        'paid_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }
}
