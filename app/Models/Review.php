<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'course_id', 'rating', 'comment', 'title',
        'rating_breakdown', 'is_verified_purchase', 'is_featured',
        'helpful_count', 'completed_at'
    ];

    protected $casts = [
        'rating_breakdown' => 'array',
        'is_verified_purchase' => 'boolean',
        'is_featured' => 'boolean',
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
