<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Listing extends Model
{
    protected $fillable = [
        'user_id', 'title', 'slug', 'description', 'type', 'category',
        'price', 'location', 'address', 'bedrooms', 'bathrooms',
        'area', 'status', 'rejection_reason', 'amenities', 'video_path',
    ];

    protected $casts = [
        'amenities' => 'array',
        'price'     => 'float',
        'area'      => 'float',
    ];

    // Auto-generate slug when creating
    protected static function booted(): void
    {
        static::creating(function ($listing) {
            $listing->slug = static::generateSlug($listing->title);
        });

        static::updating(function ($listing) {
            if ($listing->isDirty('title')) {
                $listing->slug = static::generateSlug($listing->title);
            }
        });
    }

    // Generate unique slug
    public static function generateSlug(string $title): string
    {
        $slug = Str::slug($title);
        $original = $slug;
        $count = 1;

        while (static::where('slug', $slug)->exists()) {
            $slug = $original . '-' . $count++;
        }

        return $slug;
    }

    // Scope for active listings
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // Relationships
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

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function conversations()
    {
        return $this->hasMany(Conversation::class, 'property_id');
    }

    // Use slug as route key
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
