<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Listing extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'title', 'description', 'type', 'category',
        'price', 'location', 'address', 'bedrooms', 'bathrooms',
        'area', 'status', 'rejection_reason',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function images()
    {
        return $this->hasMany(ListingImage::class);
    }

    public function primaryImage()
    {
        return $this->hasOne(ListingImage::class)->where('is_primary', true);
    }
}
