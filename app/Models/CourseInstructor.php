<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CourseInstructor extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id', 'name', 'bio', 'experience', 'title', 'company',
        'linkedin_url', 'image', 'expertise', 'years_experience', 'is_primary'
    ];

    protected $casts = [
        'expertise' => 'array',
        'is_primary' => 'boolean',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? Storage::disk('public')->url($this->image) : null;
    }
}
