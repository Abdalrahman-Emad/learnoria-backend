<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Course;
use App\Models\Review;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(ReviewRequest $request, Course $course)

    {
        // Check if user completed the course
        $enrollment = Enrollment::where('student_id', auth()->id())
            ->where('course_id', $course->id)
            ->where('status', 'completed') // ✅ بدل enrolled
            ->first();

        if (!$enrollment) {
            return response()->json(['message' => 'You must complete this course to review it'], 403);
        }

        // Check if user already reviewed
        if (Review::where('user_id', auth()->id())->where('course_id', $course->id)->exists()) {
            return response()->json(['message' => 'You have already reviewed this course'], 409);
        }

        $review = Review::create([
            'user_id' => auth()->id(),
            'course_id' => $course->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'title' => $request->title,

        ]);

        return new ReviewResource($review->load('user'));
    }

    public function update(ReviewRequest $request, Review $review)
    {
        if ($review->user_id !== auth()->id()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $review->update($request->validated());

        return new ReviewResource($review->load('user'));
    }

    public function destroy(Review $review)
    {
        if ($review->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $review->delete();

        return response()->json(['message' => 'Review deleted successfully']);
    }

    public function courseReviews(Course $course)
    {
        $reviews = Review::with(['user'])
            ->where('course_id', $course->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return ReviewResource::collection($reviews);
    }
}
