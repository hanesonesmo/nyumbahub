<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ip_address',
        'user_agent',
        'status', // e.g. 'success', 'failed', 'lockout', 'logout'
        'device',
        'browser',
        'platform',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
