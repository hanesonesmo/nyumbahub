<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentTransaction extends Model
{
    protected $fillable = [
        'transaction_id',
        'user_id',
        'agent_id',
        'listing_id',
        'type',
        'amount',
        'currency',
        'status',
        'payment_method',
        'mpesa_receipt',
        'phone_number',
        'result_desc',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }
}
