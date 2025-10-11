<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    public function toArray($request)
    {
        $user = $request->user();

        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'field' => $this->field,
            'city' => $this->city,
            'price' => $this->price,
            'discounted_price' => $this->discounted_price,
            'duration' => $this->duration,
            'total_duration' => $this->total_duration,

            'image' => $this->getImageUrl(),

            'status' => $this->status,
            'max_students' => $this->max_students,
            'start_date' => $this->start_date,
            'level' => $this->level,
            'language' => $this->language,

            // Learning outcomes
            'learning_outcomes' => $this->learning_outcomes,
            'target_audience' => $this->target_audience,
            'course_highlights' => $this->course_highlights,

            // Course includes
            'course_includes' => [
                'certificate' => $this->has_certificate,
                'total_lectures' => $this->total_lectures,
                'total_projects' => $this->total_projects,
                'total_assignments' => $this->total_assignments,
                'duration_hours' => round($this->total_duration / 60, 1),
            ],

            // Prerequisites
            'requirements' => $this->requirements,

            // Wishlist & enrollment status
            'wishlist_count' => $this->wishlist_count,
            'is_wishlisted' => $user ? $this->isWishlistedBy($user->id) : false,
            'is_enrolled' => $user ? $user->enrollments()->where('course_id', $this->id)->exists() : false,
            'is_owned' => $user ? $this->provider_id === $user->id : false,

            // Pricing & Offers
            'pricing' => [
                'original_price' => $this->price,
                'current_price' => $this->discounted_price,
                'discount_percentage' => $this->price > 0 ? round((($this->price - $this->discounted_price) / $this->price) * 100) : 0,
                'active_coupon' => $this->active_coupon ? [
                    'code' => $this->active_coupon->code,
                    'name' => $this->active_coupon->name,
                    'type' => $this->active_coupon->type,
                    'value' => $this->active_coupon->value,
                    'expires_at' => $this->active_coupon->expires_at,
                ] : null,
            ],

            // Ratings & Reviews
            'ratings' => [
                'average_rating' => round($this->average_rating, 1),
                'reviews_count' => $this->reviews_count,
                'rating_breakdown' => $this->rating_breakdown,
            ],

            'enrolled_students_count' => $this->enrolled_students_count,
            'provider' => new UserResource($this->whenLoaded('provider')),

            // Course content
            'sections' => CourseSectionResource::collection($this->whenLoaded('sections')),

            // Instructors
            'instructors' => CourseInstructorResource::collection($this->whenLoaded('instructors')),
            'primary_instructor' => new CourseInstructorResource($this->whenLoaded('primaryInstructor')),

            // Featured Reviews
            'featured_reviews' => ReviewResource::collection($this->whenLoaded('reviews')->where('is_featured', true)->take(3)),

            'created_at' => $this->created_at,
        ];
    }

    /**
     * Get the properly formatted image URL
     */
    private function getImageUrl()
    {
        // Return null or placeholder if no image
        if (empty($this->image)) {
            return null; // or return a placeholder URL if needed
        }

        $image = trim($this->image);

        // Check if it's already a full URL (Cloudinary, S3, etc.)
        if (str_starts_with($image, 'http://') || str_starts_with($image, 'https://')) {
            return $image;
        }

        // Otherwise, it's a relative path on our backend
        return url('images/' . ltrim($image, '/'));
    }
}