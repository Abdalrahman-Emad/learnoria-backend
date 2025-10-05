<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id', 'title', 'description', 'order_index'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function lectures()
    {
        return $this->hasMany(CourseLecture::class)->orderBy('order_index');
    }

    public function getTotalDurationAttribute()
    {
        return $this->lectures->sum('duration_minutes');
    }
}
