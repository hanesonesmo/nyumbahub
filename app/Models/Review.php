<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id',
        'listing_id',
        'agent_id',
        'user_id',
        'rating',
        'review_title',
        'review_text',
        'agent_response',
        'status',
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

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function reports()
    {
        return $this->hasMany(ReviewReport::class);
    }

    // Scopes
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    protected static function booted()
    {
        $recalculate = function ($review) {
            if ($review->agent && $review->agent->agentProfile) {
                $review->agent->agentProfile->recalculateRatings();
            }
        };

        static::saved($recalculate);
        static::deleted($recalculate);
    }
}
