<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'bio',
        'city',
        'avatar',
        'avatar_public_id',
        'status'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relationships
    public function courses()
    {
        return $this->hasMany(Course::class, 'provider_id');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'student_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Wishlist relationships
    public function wishlist()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function wishlistCourses()
    {
        return $this->belongsToMany(Course::class, 'wishlists')
            ->withTimestamps()
            ->orderBy('wishlists.created_at', 'desc');
    }

    // Helper
    public function hasInWishlist($courseId)
    {
        return $this->wishlist()->where('course_id', $courseId)->exists();
    }

    // Scopes
    public function scopeProviders($query)
    {
        return $query->where('role', 'provider');
    }

    public function scopeStudents($query)
    {
        return $query->where('role', 'student');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
