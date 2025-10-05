<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create Admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@learnoria.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'city' => 'Cairo',
        ]);

        // Create Providers
        User::create([
            'name' => 'John Smith',
            'email' => 'john.provider@example.com',
            'password' => Hash::make('password'),
            'role' => 'provider',
            'phone' => '+201234567890',
            'bio' => 'Experienced programming instructor with 10+ years in web development.',
            'city' => 'Cairo',
        ]);

        User::create([
            'name' => 'Sarah Johnson',
            'email' => 'sarah.provider@example.com',
            'password' => Hash::make('password'),
            'role' => 'provider',
            'phone' => '+201234567891',
            'bio' => 'Digital marketing expert and certified trainer.',
            'city' => 'Alexandria',
        ]);

        // Create Students
        User::create([
            'name' => 'Ahmed Mohamed',
            'email' => 'ahmed.student@example.com',
            'password' => Hash::make('password'),
            'role' => 'student',
            'phone' => '+201234567892',
            'city' => 'Cairo',
        ]);

        User::create([
            'name' => 'Fatima Ali',
            'email' => 'fatima.student@example.com',
            'password' => Hash::make('password'),
            'role' => 'student',
            'phone' => '+201234567893',
            'city' => 'Giza',
        ]);

        User::create([
            'name' => 'Omar Hassan',
            'email' => 'omar.student@example.com',
            'password' => Hash::make('password'),
            'role' => 'student',
            'phone' => '+201234567894',
            'city' => 'Alexandria',
        ]);
    }
}