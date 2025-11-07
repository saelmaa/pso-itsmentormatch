<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Session extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'mentor_id',
        'topic',
        'description',
        'session_date',
        'session_time',
        'duration',
        'type',
        'status',
        'notes',
    ];

    protected $casts = [
        'session_date' => 'date',
        'session_time' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mentor()
    {
        return $this->belongsTo(Mentor::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Check if session is in the past
    public function isPast()
    {
        $sessionDateTime = Carbon::parse($this->session_date->format('Y-m-d') . ' ' . $this->session_time->format('H:i:s'));
        return $sessionDateTime->lt(now());
    }

    // Check if session can be edited
    public function canBeEdited()
    {
        return in_array($this->status, ['pending', 'confirmed']) && !$this->isPast();
    }

    // Check if session can be cancelled
    public function canBeCancelled()
    {
        return in_array($this->status, ['pending', 'confirmed']) && !$this->isPast();
    }

    // Scope for user's sessions
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // Scope for upcoming sessions
    public function scopeUpcoming($query)
    {
        return $query->where('session_date', '>=', now()->toDateString())
                    ->where('status', '!=', 'cancelled');
    }
    
    // Review
    public function review()
    {
        return $this->hasOne(Review::class);
    }

}