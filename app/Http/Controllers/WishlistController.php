<?php

namespace App\Http\Controllers;

use App\Http\Resources\CourseResource;
use App\Models\Course;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class WishlistController extends Controller
{
    /**
     * Get user's wishlist
     */
    public function index(Request $request)
    {
        $user = $request->user();
        
        // Get wishlist with course details
        $wishlistCourses = $user->wishlistCourses()
                               ->with(['provider', 'reviews', 'wishlists'])
                               ->approved()
                               ->paginate($request->per_page ?? 12);

        return response()->json([
            'message' => 'Wishlist retrieved successfully',
            'wishlist' => CourseResource::collection($wishlistCourses),
            'total_items' => $user->wishlist()->count(),
        ]);
    }

    /**
     * Add course to wishlist
     */
    public function store(Request $request, Course $course)
    {
        $user = $request->user();

        // Check if course is already in wishlist
        if ($user->hasInWishlist($course->id)) {
            return response()->json([
                'message' => 'Course is already in your wishlist'
            ], 409);
        }

        // Check if user is already enrolled
        if ($user->enrollments()->where('course_id', $course->id)->exists()) {
            return response()->json([
                'message' => 'You are already enrolled in this course'
            ], 409);
        }

        // Check if user owns the course (providers can't wishlist their own courses)
        if ($course->provider_id === $user->id) {
            return response()->json([
                'message' => 'You cannot add your own course to wishlist'
            ], 403);
        }

        // Add to wishlist
        Wishlist::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
        ]);

        return response()->json([
            'message' => 'Course added to wishlist successfully',
            'course' => new CourseResource($course->load(['provider', 'reviews'])),
            'wishlist_count' => $user->wishlist()->count(),
        ], 201);
    }

    /**
     * Remove course from wishlist
     */
    public function destroy(Request $request, Course $course)
    {
        $user = $request->user();

        $wishlistItem = Wishlist::where('user_id', $user->id)
                               ->where('course_id', $course->id)
                               ->first();

        if (!$wishlistItem) {
            return response()->json([
                'message' => 'Course not found in your wishlist'
            ], 404);
        }

        $wishlistItem->delete();

        return response()->json([
            'message' => 'Course removed from wishlist successfully',
            'wishlist_count' => $user->wishlist()->count(),
        ]);
    }

    /**
     * Toggle course in/out of wishlist
     */
    public function toggle(Request $request, Course $course)
    {
        $user = $request->user();

        // Check if user owns the course
        if ($course->provider_id === $user->id) {
            return response()->json([
                'message' => 'You cannot add your own course to wishlist'
            ], 403);
        }

        $wishlistItem = Wishlist::where('user_id', $user->id)
                               ->where('course_id', $course->id)
                               ->first();

        if ($wishlistItem) {
            // Remove from wishlist
            $wishlistItem->delete();
            $action = 'removed';
            $inWishlist = false;
        } else {
            // Add to wishlist (but check enrollment first)
            if ($user->enrollments()->where('course_id', $course->id)->exists()) {
                return response()->json([
                    'message' => 'You are already enrolled in this course'
                ], 409);
            }

            Wishlist::create([
                'user_id' => $user->id,
                'course_id' => $course->id,
            ]);
            $action = 'added';
            $inWishlist = true;
        }

        return response()->json([
            'message' => "Course {$action} to/from wishlist successfully",
            'in_wishlist' => $inWishlist,
            'wishlist_count' => $user->wishlist()->count(),
        ]);
    }

    /**
     * Check if course is in user's wishlist
     */
    public function check(Request $request, Course $course)
    {
        $user = $request->user();
        $inWishlist = $user->hasInWishlist($course->id);

        return response()->json([
            'in_wishlist' => $inWishlist,
            'wishlist_count' => $user->wishlist()->count(),
        ]);
    }

    /**
     * Clear entire wishlist
     */
    public function clear(Request $request)
    {
        $user = $request->user();
        $deletedCount = $user->wishlist()->count();
        
        $user->wishlist()->delete();

        return response()->json([
            'message' => 'Wishlist cleared successfully',
            'deleted_items' => $deletedCount,
        ]);
    }

    /**
     * Move wishlist items to cart/enrollment (batch operation)
     */
    public function moveToCart(Request $request)
    {
        $request->validate([
            'course_ids' => 'required|array',
            'course_ids.*' => 'required|integer|exists:courses,id'
        ]);

        $user = $request->user();
        $courseIds = $request->course_ids;

        // Get wishlist items for these courses
        $wishlistItems = $user->wishlist()
                             ->whereIn('course_id', $courseIds)
                             ->with('course')
                             ->get();

        if ($wishlistItems->isEmpty()) {
            return response()->json([
                'message' => 'No valid wishlist items found'
            ], 404);
        }

        $results = [];
        $totalPrice = 0;

        foreach ($wishlistItems as $wishlistItem) {
            $course = $wishlistItem->course;
            
            // Check if already enrolled
            if ($user->enrollments()->where('course_id', $course->id)->exists()) {
                $results[] = [
                    'course_id' => $course->id,
                    'course_title' => $course->title,
                    'status' => 'already_enrolled'
                ];
                continue;
            }

            // Calculate price (with discounts if applicable)
            $price = $course->discounted_price;
            $totalPrice += $price;

            $results[] = [
                'course_id' => $course->id,
                'course_title' => $course->title,
                'price' => $price,
                'status' => 'ready_for_checkout'
            ];

            // Remove from wishlist
            $wishlistItem->delete();
        }

        return response()->json([
            'message' => 'Wishlist items processed successfully',
            'items' => $results,
            'total_price' => $totalPrice,
            'remaining_wishlist_count' => $user->wishlist()->count(),
        ]);
    }
}