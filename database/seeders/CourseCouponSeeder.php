<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseCoupon;
use Illuminate\Database\Seeder;

class CourseCouponSeeder extends Seeder
{
    public function run()
    {
        $courses = Course::all();

        $coupons = [
            [
                'code' => 'EARLY25',
                'name' => 'Early Bird Special',
                'type' => 'percentage',
                'value' => 25.00,
                'usage_limit' => 50,
                'starts_at' => now()->subDays(5),
                'expires_at' => now()->addDays(30),
                'is_active' => true,
            ],
            [
                'code' => 'STUDENT20',
                'name' => 'Student Discount',
                'type' => 'percentage', 
                'value' => 20.00,
                'usage_limit' => 100,
                'starts_at' => now()->subDays(10),
                'expires_at' => now()->addDays(60),
                'is_active' => true,
            ],
            [
                'code' => 'FLASH500',
                'name' => 'Flash Sale',
                'type' => 'fixed',
                'value' => 500.00,
                'usage_limit' => 20,
                'starts_at' => now()->subDays(2),
                'expires_at' => now()->addDays(7),
                'is_active' => true,
            ],
            [
                'code' => 'NEWUSER15',
                'name' => 'New User Discount',
                'type' => 'percentage',
                'value' => 15.00,
                'usage_limit' => null, // unlimited
                'starts_at' => now()->subDays(30),
                'expires_at' => now()->addDays(90),
                'is_active' => true,
            ]
        ];

        foreach ($courses as $course) {
            // Pick 1-2 random coupons per course
            $courseCoupons = collect($coupons)->random(rand(1, 2));
            
            foreach ($courseCoupons as $couponData) {
                CourseCoupon::create([
                    'course_id' => $course->id,
                    'code' => $couponData['code'] . '_' . $course->id, // unique per course
                    'name' => $couponData['name'],
                    'type' => $couponData['type'],
                    'value' => $couponData['value'],
                    'usage_limit' => $couponData['usage_limit'],
                    'used_count' => rand(0, $couponData['usage_limit'] ?? 5),
                    'starts_at' => $couponData['starts_at'],
                    'expires_at' => $couponData['expires_at'],
                    'is_active' => $couponData['is_active'],
                ]);
            }
        }
    }
}
