<?php

namespace Database\Seeders;

use App\Models\Enrollment;
use App\Models\Review;
use App\Models\Course;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run()
    {
        // ✅ Use delete instead of truncate (safer with foreign keys)
        Review::query()->delete();

        $reviewTemplates = [
            [
                'title' => 'Excellent course with practical projects!',
                'comment' => 'This course exceeded my expectations. The instructor was knowledgeable and the hands-on projects really helped me understand the concepts. Highly recommended for anyone looking to advance their skills.',
                'rating' => 5,
                'is_featured' => true,
                'rating_breakdown' => [
                    'content_quality' => 5,
                    'instructor_expertise' => 5,
                    'practical_value' => 5,
                    'course_organization' => 4
                ]
            ],
            [
                'title' => 'Great learning experience',
                'comment' => 'Well-structured course with clear explanations. The pace was perfect for beginners and the support from instructors was amazing.',
                'rating' => 5,
                'is_featured' => true,
                'rating_breakdown' => [
                    'content_quality' => 5,
                    'instructor_expertise' => 5,
                    'practical_value' => 4,
                    'course_organization' => 5
                ]
            ],
            [
                'title' => 'Very informative and well-organized',
                'comment' => 'The course content was comprehensive and up-to-date. I learned a lot and was able to apply the knowledge immediately in my work.',
                'rating' => 4,
                'is_featured' => true,
                'rating_breakdown' => [
                    'content_quality' => 4,
                    'instructor_expertise' => 4,
                    'practical_value' => 4,
                    'course_organization' => 4
                ]
            ],
            [
                'title' => 'Good course but could be improved',
                'comment' => 'Overall a good learning experience. Some sections could use more detailed examples, but the core content is solid.',
                'rating' => 4,
                'is_featured' => false,
                'rating_breakdown' => [
                    'content_quality' => 4,
                    'instructor_expertise' => 4,
                    'practical_value' => 3,
                    'course_organization' => 4
                ]
            ],
            [
                'title' => 'Perfect for career transition',
                'comment' => 'As someone switching careers, this course provided exactly what I needed. The job placement support was particularly valuable.',
                'rating' => 5,
                'is_featured' => true,
                'rating_breakdown' => [
                    'content_quality' => 5,
                    'instructor_expertise' => 5,
                    'practical_value' => 5,
                    'course_organization' => 5
                ]
            ],
        ];

        // ✅ Get only approved courses
        $coursesWithEnrollments = Enrollment::with('student', 'course')
            ->whereHas('course', function($query) {
                $query->where('status', 'approved');
            })
            ->get()
            ->groupBy('course_id');

        if ($coursesWithEnrollments->isEmpty()) {
            $this->command->warn('⚠️  No enrollments found! Please run EnrollmentSeeder first.');
            return;
        }

        $totalReviews = 0;

        foreach ($coursesWithEnrollments as $courseId => $enrollments) {
            $students = $enrollments->pluck('student')->unique('id');

            if ($students->isEmpty()) {
                continue;
            }

            // ✅ At least 2 reviews per course (or max available students)
            $numReviews = max(2, min(rand(2, 5), $students->count()));
            $studentsToReview = $students->shuffle()->take($numReviews);

            foreach ($studentsToReview as $student) {
                $template = collect($reviewTemplates)->random();

                Review::updateOrCreate(
                    [
                        'user_id' => $student->id,
                        'course_id' => $courseId,
                    ],
                    [
                        'title' => $template['title'],
                        'comment' => $template['comment'],
                        'rating' => $template['rating'],
                        'is_featured' => $template['is_featured'],
                        'rating_breakdown' => $template['rating_breakdown'],
                        'is_verified_purchase' => true,
                        'completed_at' => now()->subDays(rand(1, 60)),
                    ]
                );
                $totalReviews++;
            }
        }

        $this->command->info("✅ {$totalReviews} reviews created successfully across " . $coursesWithEnrollments->count() . " courses!");
    }
}