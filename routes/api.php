<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\WishlistController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/courses', [CourseController::class, 'index']);
Route::get('/courses/{course}', [CourseController::class, 'show']);
Route::get('/courses/{course}/reviews', [ReviewController::class, 'courseReviews']);
Route::get('/courses/{course}/related', [CourseController::class, 'relatedCourses']);





// New endpoints for dropdowns
Route::get('/cities', function () {
    $cities = \App\Models\Course::select('city')->distinct()->pluck('city');
    return response()->json($cities);
});

Route::get('/fields', function () {
    $fields = \App\Models\Course::select('field')->distinct()->pluck('field');
    return response()->json($fields);
});


Route::middleware('auth:sanctum')->group(function () {
    // Auth routes
    Route::post('/logout', [AuthController::class, 'logout']);

    // Profile routes (protected)
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::put('/profile', [AuthController::class, 'updateProfile']); // Update profile (with/without avatar)
    Route::delete('/profile/avatar', [AuthController::class, 'deleteAvatar']); // Delete avatar


    // Student-only routes
    Route::middleware([RoleMiddleware::class . ':student'])->group(function () {
        Route::post('/courses/{course}/enroll', [EnrollmentController::class, 'enroll']);
        Route::get('/my-enrollments', [EnrollmentController::class, 'myEnrollments']);
        Route::put('/enrollments/{enrollment}/status', [EnrollmentController::class, 'updateStatus']);
        Route::post('/courses/{course}/reviews', [ReviewController::class, 'store']);
        Route::put('/reviews/{review}', [ReviewController::class, 'update']);
        Route::delete('/reviews/{review}', [ReviewController::class, 'destroy']);
    });

    // Provider-only routes
    Route::middleware([RoleMiddleware::class . ':provider'])->group(function () {
        Route::post('/courses', [CourseController::class, 'store']);
        Route::get('/my-courses', [CourseController::class, 'myCourses']);
        Route::get('/courses/{course}/students', [EnrollmentController::class, 'courseStudents']);
    });

    // Admin-only routes
    Route::middleware([RoleMiddleware::class . ':admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
        Route::get('/admin/users', [AdminController::class, 'users']);
        Route::put('/admin/users/{user}/role', [AdminController::class, 'updateUserRole']);
        Route::put('/admin/users/{user}/status', [AdminController::class, 'updateUserStatus']);
        Route::delete('/admin/users/{user}', [AdminController::class, 'deleteUser']);
        Route::get('/admin/courses/pending', [CourseController::class, 'pending']);
        Route::put('/courses/{course}/approve', [CourseController::class, 'approve']);
        Route::put('/courses/{course}/reject', [CourseController::class, 'reject']);
    });

    // Provider or Admin routes (for course management)
    Route::middleware([RoleMiddleware::class . ':provider,admin'])->group(function () {
        Route::put('/courses/{course}', [CourseController::class, 'update']);
        Route::delete('/courses/{course}', [CourseController::class, 'destroy']);
    });


    // Wishlist routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::prefix('wishlist')->group(function () {
            Route::get('/', [WishlistController::class, 'index']);                       // GET /api/wishlist
            Route::post('/courses/{course}', [WishlistController::class, 'store']);      // POST /api/wishlist/courses/{id}
            Route::delete('/courses/{course}', [WishlistController::class, 'destroy']);  // DELETE /api/wishlist/courses/{id}
            Route::post('/courses/{course}/toggle', [WishlistController::class, 'toggle']); // POST /api/wishlist/courses/{id}/toggle
            Route::get('/courses/{course}/check', [WishlistController::class, 'check']); // GET /api/wishlist/courses/{id}/check
            Route::delete('/clear', [WishlistController::class, 'clear']);              // DELETE /api/wishlist/clear
            Route::post('/move-to-cart', [WishlistController::class, 'moveToCart']);    // POST /api/wishlist/move-to-cart
        });
    });
});
