<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Database\Seeder;

class EnrollmentSeeder extends Seeder
{
public function run()
{
    $students = User::where('role', 'student')->get();
    $courses = Course::where('status', 'approved')->get();

    // 1️⃣ نضمن إن كل كورس له طالب واحد على الأقل
    foreach ($courses as $course) {
        $student = $students->random();
        Enrollment::updateOrCreate(
            [
                'student_id' => $student->id,
                'course_id' => $course->id,
            ],
            [
                'status' => 'enrolled',
                'enrolled_at' => now()->subDays(rand(1, 30)),
            ]
        );
    }

    // 2️⃣ ثم نكمل تسجيل باقي الطلاب في كورسات عشوائية
    foreach ($students as $student) {
        $coursesToEnroll = $courses->random(min(rand(1, 3), $courses->count()));

        foreach ($coursesToEnroll as $course) {
            Enrollment::updateOrCreate(
                [
                    'student_id' => $student->id,
                    'course_id' => $course->id,
                ],
                [
                    'status' => 'enrolled',
                    'enrolled_at' => now()->subDays(rand(1, 30)),
                ]
            );
        }
    }
}
}