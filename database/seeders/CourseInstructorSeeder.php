<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseInstructor;
use Illuminate\Database\Seeder;

class CourseInstructorSeeder extends Seeder
{
    public function run()
    {
        $courses = Course::all();

        $instructorTemplates = [
            'Programming' => [
                [
                    'name' => 'Ahmed Hassan',
                    'bio' => 'Senior Full Stack Developer with 8+ years of experience in web development. Former tech lead at major Egyptian startups.',
                    'experience' => 'Senior Developer at Vodafone Egypt, Former Udacity Mentor, 5+ years teaching experience',
                    'title' => 'Senior Full Stack Developer',
                    'company' => 'Vodafone Egypt',
                    'linkedin_url' => 'https://linkedin.com/in/ahmed-hassan-dev',
                    'expertise' => ['JavaScript', 'React', 'Node.js', 'Python', 'MongoDB'],
                    'years_experience' => 8,
                    'is_primary' => true,
                ],
                [
                    'name' => 'Sara Mohamed',
                    'bio' => 'Frontend specialist with expertise in modern React development and UI/UX principles.',
                    'experience' => 'Frontend Developer at Swvl, React.js certified instructor',
                    'title' => 'Frontend Developer',
                    'company' => 'Swvl',
                    'linkedin_url' => 'https://linkedin.com/in/sara-mohamed-fe',
                    'expertise' => ['React', 'TypeScript', 'CSS', 'UI/UX'],
                    'years_experience' => 5,
                    'is_primary' => false,
                ]
            ],
            'Marketing' => [
                [
                    'name' => 'Omar Abdallah',
                    'bio' => 'Digital marketing expert with 10+ years helping Egyptian businesses grow online. Google Ads certified professional.',
                    'experience' => 'Marketing Director at Jumia Egypt, Former Google Partner',
                    'title' => 'Digital Marketing Director',
                    'company' => 'Jumia Egypt',
                    'linkedin_url' => 'https://linkedin.com/in/omar-abdallah-marketing',
                    'expertise' => ['SEO', 'Google Ads', 'Social Media', 'Analytics'],
                    'years_experience' => 10,
                    'is_primary' => true,
                ]
            ],
            'Data Science' => [
                [
                    'name' => 'Dr. Mona Farouk',
                    'bio' => 'Data Science PhD with extensive experience in machine learning and AI applications in Egyptian market.',
                    'experience' => 'Senior Data Scientist at Microsoft Cairo, University Professor',
                    'title' => 'Senior Data Scientist',
                    'company' => 'Microsoft Cairo',
                    'linkedin_url' => 'https://linkedin.com/in/mona-farouk-ds',
                    'expertise' => ['Python', 'Machine Learning', 'Deep Learning', 'Statistics'],
                    'years_experience' => 12,
                    'is_primary' => true,
                ]
            ],
            'Design' => [
                [
                    'name' => 'Yasmin Tarek',
                    'bio' => 'Award-winning UX designer with experience creating user-centered designs for leading Middle Eastern companies.',
                    'experience' => 'Lead UX Designer at Careem, Adobe certified instructor',
                    'title' => 'Lead UX Designer',
                    'company' => 'Careem',
                    'linkedin_url' => 'https://linkedin.com/in/yasmin-tarek-ux',
                    'expertise' => ['Figma', 'Adobe XD', 'User Research', 'Prototyping'],
                    'years_experience' => 7,
                    'is_primary' => true,
                ]
            ],
            'Cybersecurity' => [
                [
                    'name' => 'Khaled Mahmoud',
                    'bio' => 'Cybersecurity specialist and ethical hacker with CISSP and CEH certifications. Expert in securing enterprise networks.',
                    'experience' => 'Security Consultant at IBM Egypt, Former penetration tester',
                    'title' => 'Senior Cybersecurity Consultant',
                    'company' => 'IBM Egypt',
                    'linkedin_url' => 'https://linkedin.com/in/khaled-mahmoud-security',
                    'expertise' => ['Penetration Testing', 'Network Security', 'Ethical Hacking', 'CISSP'],
                    'years_experience' => 9,
                    'is_primary' => true,
                ]
            ]
        ];

        foreach ($courses as $course) {
            // اختر مدرب واحد أساسي و1-2 مدربين إضافيين حسب المجال
            $fieldInstructors = $instructorTemplates[$course->field] ?? [
                [
                    'name' => 'Expert Instructor',
                    'bio' => 'Experienced professional in ' . $course->field,
                    'experience' => '5+ years of industry experience',
                    'title' => 'Senior ' . $course->field . ' Specialist',
                    'company' => 'Leading Company',
                    'linkedin_url' => 'https://linkedin.com/in/expert-instructor',
                    'expertise' => [ucfirst($course->field)],
                    'years_experience' => 5,
                    'is_primary' => true,
                ]
            ];

            foreach ($fieldInstructors as $instructorData) {
                CourseInstructor::create(array_merge($instructorData, [
                    'course_id' => $course->id,
                ]));
            }
        }
    }
}
