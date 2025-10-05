<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('field');
            $table->string('city');
            $table->decimal('price', 8, 2);
            $table->integer('duration'); // in hours
            $table->foreignId('provider_id')->constrained('users')->onDelete('cascade');
            $table->string('image')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->integer('max_students')->default(50);
            $table->date('start_date')->nullable();

            // ✅ الأعمدة الجديدة
            $table->json('learning_outcomes')->nullable(); 
            $table->boolean('has_certificate')->default(false);
            $table->integer('total_lectures')->default(0);
            $table->integer('total_projects')->default(0);
            $table->integer('total_assignments')->default(0);
            $table->json('requirements')->nullable();
            $table->enum('level', ['beginner', 'intermediate', 'advanced'])->default('beginner');
            $table->string('language')->default('Arabic');
            $table->text('target_audience')->nullable();
            $table->json('course_highlights')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('courses');
    }
}
