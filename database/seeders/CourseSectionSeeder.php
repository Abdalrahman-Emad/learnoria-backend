<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseSection;
use App\Models\CourseLecture;
use Illuminate\Database\Seeder;

class CourseSectionSeeder extends Seeder
{
    public function run()
    {
        $courses = Course::all();

        $sectionTemplates = [
            'Full Stack Web Development Bootcamp' => [
                [
                    'title' => 'Introduction to Web Development',
                    'description' => 'Overview of web technologies and development environment setup',
                    'lectures' => [
                        ['title' => 'What is Web Development?', 'duration' => 45, 'type' => 'lecture', 'free' => true],
                        ['title' => 'Setting up Development Environment', 'duration' => 60, 'type' => 'practical', 'free' => true],
                        ['title' => 'HTML Fundamentals', 'duration' => 90, 'type' => 'lecture', 'free' => false],
                        ['title' => 'CSS Basics', 'duration' => 90, 'type' => 'practical', 'free' => false],
                    ]
                ],
                [
                    'title' => 'JavaScript Fundamentals',
                    'description' => 'Core JavaScript concepts and ES6+ features',
                    'lectures' => [
                        ['title' => 'Variables and Data Types', 'duration' => 60, 'type' => 'lecture', 'free' => false],
                        ['title' => 'Functions and Scope', 'duration' => 75, 'type' => 'practical', 'free' => false],
                        ['title' => 'DOM Manipulation', 'duration' => 90, 'type' => 'practical', 'free' => false],
                    ]
                ]
            ],
            'Digital Marketing Masterclass 2024' => [
                [
                    'title' => 'Digital Marketing Foundations',
                    'description' => 'Understanding digital marketing landscape and strategy',
                    'lectures' => [
                        ['title' => 'Digital Marketing Overview', 'duration' => 45, 'type' => 'lecture', 'free' => true],
                        ['title' => 'Creating Marketing Personas', 'duration' => 60, 'type' => 'practical', 'free' => true],
                        ['title' => 'Marketing Funnel Strategy', 'duration' => 75, 'type' => 'lecture', 'free' => false],
                    ]
                ]
            ]
        ];

        foreach ($courses as $course) {
            $sections = $sectionTemplates[$course->title] ?? [];

            // إذا الكورس غير موجود في القالب، إنشاء sections عشوائية
            if (empty($sections)) {
                $sections = [];
                $numSections = rand(3,5);
                for ($s=1; $s <= $numSections; $s++) {
                    $numLectures = rand(2,5);
                    $lectures = [];
                    for ($l=1; $l <= $numLectures; $l++) {
                        $lectures[] = [
                            'title' => "Lecture $l of Section $s",
                            'duration' => rand(30, 180),
                            'type' => ['lecture','practical','assignment'][array_rand(['lecture','practical','assignment'])],
                            'free' => rand(0, 100) < 40, // حوالي 40% مجانية
                        ];
                    }
                    $sections[] = [
                        'title' => "Section $s: Topic Overview",
                        'description' => "Detailed content for section $s of course " . $course->title,
                        'lectures' => $lectures,
                    ];
                }
            }

            foreach ($sections as $index => $sectionData) {
                $section = CourseSection::create([
                    'course_id' => $course->id,
                    'title' => $sectionData['title'],
                    'description' => $sectionData['description'],
                    'order_index' => $index + 1,
                ]);

                foreach ($sectionData['lectures'] as $lectureIndex => $lectureData) {
                    CourseLecture::create([
                        'course_section_id' => $section->id,
                        'title' => $lectureData['title'],
                        'description' => 'Detailed explanation of ' . strtolower($lectureData['title']),
                        'duration_minutes' => $lectureData['duration'],
                        'type' => $lectureData['type'],
                        'order_index' => $lectureIndex + 1,
                        'is_free_preview' => $lectureData['free'],
                    ]);
                }
            }
        }
    }
}
