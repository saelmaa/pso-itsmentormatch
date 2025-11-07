<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'user_id',
        'mentor_id',
        'rating',
        'feedback',
    ];

    public function session()
    {
        return $this->belongsTo(Session::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mentor()
    {
        return $this->belongsTo(Mentor::class);
    }

    // Automatically update mentor rating after creating/updating review
    protected static function booted()
    {
        static::created(function ($review) {
            $review->mentor->updateRating();
        });

        static::updated(function ($review) {
            $review->mentor->updateRating();
        });

        static::deleted(function ($review) {
            $review->mentor->updateRating();
        });
    }
}
