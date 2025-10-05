<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'field', 'city', 'price', 'duration',
        'provider_id', 'image', 'status', 'max_students', 'start_date',
        'learning_outcomes', 'has_certificate', 'total_lectures', 
        'total_projects', 'total_assignments', 'requirements', 'level',
        'language', 'target_audience', 'course_highlights'
    ];

    protected $casts = [
        'start_date' => 'date',
        'price' => 'decimal:2',
        'learning_outcomes' => 'array',
        'requirements' => 'array',
        'course_highlights' => 'array',
        'has_certificate' => 'boolean',
    ];

    // Relationships
    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'enrollments', 'course_id', 'student_id')
                    ->withPivot('status', 'enrolled_at')
                    ->withTimestamps();
    }

    public function coupons()
    {
        return $this->hasMany(CourseCoupon::class);
    }

    public function sections()
    {
        return $this->hasMany(CourseSection::class)->orderBy('order_index');
    }

    public function instructors()
    {
        return $this->hasMany(CourseInstructor::class);
    }

    public function primaryInstructor()
    {
        return $this->hasOne(CourseInstructor::class)->where('is_primary', true);
    }

    // Wishlist relationships
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function wishlistedBy()
    {
        return $this->belongsToMany(User::class, 'wishlists')
                    ->withTimestamps()
                    ->orderBy('wishlists.created_at', 'desc');
    }

    // Accessors / Helpers
    public function getDiscountedPriceAttribute()
    {
        $activeCoupon = $this->coupons()
                             ->where('is_active', true)
                             ->where('starts_at', '<=', now())
                             ->where('expires_at', '>=', now())
                             ->where(function($q) {
                                 $q->whereNull('usage_limit')
                                   ->orWhereColumn('used_count', '<', 'usage_limit');
                             })
                             ->first();

        if (!$activeCoupon) return $this->price;

        return $activeCoupon->type === 'percentage'
            ? $this->price * (1 - $activeCoupon->value / 100)
            : max(0, $this->price - $activeCoupon->value);
    }

    public function getActiveCouponAttribute()
    {
        return $this->coupons()
                    ->where('is_active', true)
                    ->where('starts_at', '<=', now())
                    ->where('expires_at', '>=', now())
                    ->where(function($q) {
                        $q->whereNull('usage_limit')
                          ->orWhereColumn('used_count', '<', 'usage_limit');
                    })
                    ->first();
    }

    public function getTotalDurationAttribute()
    {
        return $this->sections()
                    ->with('lectures')
                    ->get()
                    ->sum(fn($section) => $section->lectures->sum('duration_minutes'));
    }

    public function getRatingBreakdownAttribute()
    {
        $reviews = $this->reviews;
        $breakdown = [];
        for ($i = 5; $i >= 1; $i--) {
            $count = $reviews->where('rating', $i)->count();
            $percentage = $reviews->count() > 0 ? round(($count / $reviews->count()) * 100) : 0;
            $breakdown[$i] = ['count' => $count, 'percentage' => $percentage];
        }
        return $breakdown;
    }

    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?: 0;
    }

    public function getReviewsCountAttribute()
    {
        return $this->reviews()->count();
    }

    public function getEnrolledStudentsCountAttribute()
    {
        return $this->enrollments()->where('status', 'enrolled')->count();
    }

    public function getWishlistCountAttribute()
    {
        return $this->wishlists()->count();
    }

    public function isWishlistedBy($userId)
    {
        return $this->wishlists()->where('user_id', $userId)->exists();
    }

    // Scopes
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeByField($query, $field)
    {
        return $query->where('field', $field);
    }

    public function scopeByCity($query, $city)
    {
        return $query->where('city', $city);
    }

    public function scopeByPriceRange($query, $minPrice, $maxPrice)
    {
        return $query->whereBetween('price', [$minPrice, $maxPrice]);
    }
}
