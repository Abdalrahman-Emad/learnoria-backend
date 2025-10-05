<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseInstructorsTable extends Migration
{
    public function up()
    {
        Schema::create('course_instructors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->text('bio');
            $table->text('experience')->nullable(); // years of experience, background
            $table->string('title')->nullable(); // job title
            $table->string('company')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('image')->nullable();
            $table->json('expertise')->nullable(); // areas of expertise
            $table->integer('years_experience')->default(0);
            $table->boolean('is_primary')->default(false); // main instructor
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('course_instructors');
    }
}