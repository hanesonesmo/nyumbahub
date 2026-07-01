<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Contracts\Auth\MustVerifyEmail;

#[Fillable(['first_name', 'last_name', 'name', 'email', 'phone', 'whatsapp', 'password', 'role', 'google_id', 'provider', 'avatar'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relationships
    public function agentApplication()
    {
        return $this->hasOne(AgentApplication::class)->latest();
    }

    public function listings()
    {
        return $this->hasMany(Listing::class, 'user_id');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'user_id');
    }

    public function agentProfile()
    {
        return $this->hasOne(AgentProfile::class);
    }

    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class);
    }

    public function favorites()
    {
        return $this->belongsToMany(Listing::class, 'favorites')->withTimestamps();
    }

    public function reviewsWritten()
    {
        return $this->hasMany(Review::class, 'user_id');
    }

    public function agentReviews()
    {
        return $this->hasMany(Review::class, 'agent_id');
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function loginHistories()
    {
        return $this->hasMany(LoginHistory::class);
    }

    public function conversationsAsUser()
    {
        return $this->hasMany(Conversation::class, 'user_id');
    }

    public function conversationsAsAgent()
    {
        return $this->hasMany(Conversation::class, 'agent_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    // Helpers
    public function isAgent(): bool
    {
        return $this->role === 'agent';
    }

    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    public function hasPendingApplication(): bool
    {
        return $this->agentApplication()
            ->where('status', 'pending')
            ->exists();
    }
}
