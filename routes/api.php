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
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

use App\Services\BrevoMailService;

Route::get('/test-mail', function () {
    $result = BrevoMailService::send('your_email@gmail.com', 'Test Mail', '<h3>Brevo API Test Successful ✅</h3>');
    return response()->json(['status' => $result ? 'sent' : 'failed']);
});


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


Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail']);
Route::post('/reset-password', [ResetPasswordController::class, 'reset']);





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






// Password Reset Routes
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
    ->middleware('throttle:3,1'); // 3 requests per minute

Route::post('/reset-password', [ResetPasswordController::class, 'reset']);

// Debug Routes (REMOVE IN PRODUCTION)
Route::get('/debug-config', function () {
    return response()->json([
        'mail_mailer' => config('mail.default'),
        'mail_host' => config('mail.mailers.smtp.host'),
        'mail_port' => config('mail.mailers.smtp.port'),
        'mail_encryption' => config('mail.mailers.smtp.encryption'),
        'mail_username' => config('mail.mailers.smtp.username'),
        'mail_username_set' => !empty(config('mail.mailers.smtp.username')),
        'mail_password_set' => !empty(config('mail.mailers.smtp.password')),
        'mail_from_address' => config('mail.from.address'),
        'mail_from_name' => config('mail.from.name'),
        'frontend_url' => config('app.frontend_url'),
        'app_url' => config('app.url'),
    ]);
});

Route::get('/test-mail', function () {
    try {
        \Illuminate\Support\Facades\Mail::raw('This is a test email from Learnoria!', function ($message) {
            $message->to('your-test-email@gmail.com') // CHANGE THIS
                    ->subject('Test Email - Learnoria');
        });

        return response()->json([
            'success' => true,
            'message' => 'Test email sent! Check your inbox (and spam folder).',
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage(),
        ], 500);
    }
});

Route::get('/test-password-reset', function () {
    try {
        $user = \App\Models\User::where('email', 'your-test-email@gmail.com')->first(); // CHANGE THIS
        
        if (!$user) {
            return response()->json(['error' => 'User not found. Create a user with this email first.'], 404);
        }

        $token = \Illuminate\Support\Str::random(60);
        \Illuminate\Support\Facades\DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            ['token' => \Illuminate\Support\Facades\Hash::make($token), 'created_at' => now()]
        );

        $user->sendPasswordResetNotification($token);

        return response()->json([
            'success' => true,
            'message' => 'Password reset notification sent!',
            'token' => $token,
            'reset_url' => config('app.frontend_url') . "/reset-password?token={$token}&email=" . urlencode($user->email)
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage(),
        ], 500);
    }
});