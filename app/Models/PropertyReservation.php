<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyReservation extends Model
{
    protected $fillable = [
        'user_id',
        'listing_id',
        'payment_transaction_id',
        'expires_at',
        'status',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }

    public function paymentTransaction()
    {
        return $this->belongsTo(PaymentTransaction::class);
    }
}
