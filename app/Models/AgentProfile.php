<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentProfile extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function recalculateRatings()
    {
        if (!$this->user) return;

        $reviews = Review::where('agent_id', $this->user_id)->approved();
        
        $this->update([
            'average_rating' => $reviews->avg('rating') ?? 0,
            'total_reviews' => $reviews->count(),
        ]);
    }
}
