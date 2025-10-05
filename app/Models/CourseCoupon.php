<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseCoupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id', 'code', 'name', 'type', 'value', 'usage_limit',
        'used_count', 'starts_at', 'expires_at', 'is_active'
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
        'value' => 'decimal:2',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function isValid()
    {
        return $this->is_active &&
               $this->starts_at <= now() &&
               $this->expires_at >= now() &&
               ($this->usage_limit === null || $this->used_count < $this->usage_limit);
    }

    public function getDiscountAmountAttribute()
    {
        if ($this->type === 'percentage') {
            return $this->course->price * ($this->value / 100);
        }
        return $this->value;
    }
}
