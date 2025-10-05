<?php

namespace App\Http\Controllers;

use App\Http\Resources\CourseResource;
use App\Http\Resources\UserResource;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function enroll(Course $course)
    {
        if ($course->status !== 'approved') {
            return response()->json(['message' => 'Course is not available for enrollment'], 400);
        }

        if ($course->enrolled_students_count >= $course->max_students) {
            return response()->json(['message' => 'Course is full'], 400);
        }

        // Check if already enrolled
        if (Enrollment::where('student_id', auth()->id())->where('course_id', $course->id)->exists()) {
            return response()->json(['message' => 'Already enrolled in this course'], 409);
        }

        Enrollment::create([
            'student_id' => auth()->id(),
            'course_id' => $course->id,
            'status' => 'enrolled',
        ]);

        return response()->json(['message' => 'Successfully enrolled in course']);
    }

    public function myEnrollments()
    {
        $enrollments = Enrollment::with(['course.provider'])
                                ->where('student_id', auth()->id())
                                ->orderBy('enrolled_at', 'desc')
                                ->get();

        return response()->json([
            'enrollments' => $enrollments->map(function ($enrollment) {
                return [
                    'id' => $enrollment->id,
                    'status' => $enrollment->status,
                    'enrolled_at' => $enrollment->enrolled_at,
                    'course' => new CourseResource($enrollment->course),
                ];
            })
        ]);
    }

    public function courseStudents(Course $course)
    {
        // Check if user owns the course
        if ($course->provider_id !== auth()->id()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $enrollments = Enrollment::with(['student'])
                                ->where('course_id', $course->id)
                                ->orderBy('enrolled_at', 'desc')
                                ->get();

        return response()->json([
            'students' => $enrollments->map(function ($enrollment) {
                return [
                    'enrollment_id' => $enrollment->id,
                    'status' => $enrollment->status,
                    'enrolled_at' => $enrollment->enrolled_at,
                    'student' => new UserResource($enrollment->student),
                ];
            })
        ]);
    }

    public function updateStatus(Enrollment $enrollment, Request $request)
    {
        $request->validate([
            'status' => 'required|in:enrolled,completed,dropped'
        ]);

        // Only student can update their own enrollment or course provider
        if ($enrollment->student_id !== auth()->id() && 
            $enrollment->course->provider_id !== auth()->id()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $enrollment->update(['status' => $request->status]);

        return response()->json(['message' => 'Enrollment status updated successfully']);
    }
}