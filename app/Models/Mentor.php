<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mentor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'department',
        'expertise',
        'bio',
        'experience_years',
        'rating',
        'total_sessions',
        'total_reviews',
        'availability_status',
        'skills',
        'location',
        'price',
    ];

    protected $casts = [
        'skills' => 'array',
        'rating' => 'decimal:2',
    ];

    public function sessions()
    {
        return $this->hasMany(Session::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Update mentor rating based on reviews
    public function updateRating()
    {
        $avgRating = $this->reviews()->avg('rating');
        $totalReviews = $this->reviews()->count();
        
        $this->update([
            'rating' => $avgRating ? round($avgRating, 2) : 0,
            'total_reviews' => $totalReviews,
        ]);
    }

    // Scope for searching mentors
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('expertise', 'like', "%{$search}%")
              ->orWhere('department', 'like', "%{$search}%");
        });
    }

    // Scope for filtering by department
    public function scopeDepartment($query, $department)
    {
        return $query->where('department', $department);
    }
}