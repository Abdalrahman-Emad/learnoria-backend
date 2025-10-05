<?php

namespace App\Services;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseService
{
    public function getFilteredCourses(Request $request)
    {
        $query = Course::with(['provider', 'reviews'])
                      ->approved();

        $this->applyFilters($query, $request);
        $this->applySorting($query, $request);

        return $query->paginate($request->per_page ?? 15);
    }

    private function applyFilters($query, Request $request)
    {
        if ($request->field) {
            $query->byField($request->field);
        }
        
        if ($request->city) {
            $query->byCity($request->city);
        }
        
        if ($request->min_price && $request->max_price) {
            $query->byPriceRange($request->min_price, $request->max_price);
        }

        if ($request->min_rating) {
            $query->whereHas('reviews', function ($q) use ($request) {
                $q->havingRaw('AVG(rating) >= ?', [$request->min_rating]);
            });
        }

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhere('field', 'like', '%' . $request->search . '%');
            });
        }
    }

    private function applySorting($query, Request $request)
    {
        switch ($request->sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'rating':
                $query->withAvg('reviews', 'rating')
                      ->orderBy('reviews_avg_rating', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }
    }

    public function getCourseStats(Course $course)
    {
        return [
            'average_rating' => round($course->reviews()->avg('rating') ?: 0, 1),
            'reviews_count' => $course->reviews()->count(),
            'enrolled_students' => $course->enrollments()->where('status', 'enrolled')->count(),
            'completed_students' => $course->enrollments()->where('status', 'completed')->count(),
        ];
    }
}
