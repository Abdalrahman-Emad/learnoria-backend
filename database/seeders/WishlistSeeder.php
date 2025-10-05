<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Database\Seeder;

class WishlistSeeder extends Seeder
{
    public function run()
    {
        $students = User::where('role', 'student')->get();
        $courses = Course::where('status', 'approved')->get();

        foreach ($students as $student) {
            $availableCourses = $courses->where('provider_id', '!=', $student->id)
                ->filter(fn($course) => !$student->enrollments()->where('course_id', $course->id)->exists());

            $count = min(rand(2, 5), $availableCourses->count());

            $randomCourses = $availableCourses->shuffle()->take($count);

            foreach ($randomCourses as $course) {
                Wishlist::create([
                    'user_id' => $student->id,
                    'course_id' => $course->id,
                    'created_at' => now()->subDays(rand(1, 30)),
                ]);
            }
        }
    }
}
