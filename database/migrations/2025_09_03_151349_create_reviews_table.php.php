<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');

            // ⭐ التقييم الأساسي
            $table->tinyInteger('rating')->unsigned(); // 1–5

            // 📝 تفاصيل الريفيو
            $table->string('title')->nullable(); // review title
            $table->text('comment')->nullable();

            // 📊 تفاصيل إضافية
            $table->json('rating_breakdown')->nullable(); // مثلا { "content":5, "instructor":4, "value":5 }
            $table->boolean('is_verified_purchase')->default(false);
            $table->boolean('is_featured')->default(false); // highlight good reviews
            $table->integer('helpful_count')->default(0); // helpful votes
            $table->datetime('completed_at')->nullable(); // تاريخ إنهاء الكورس

            $table->timestamps();

            // 🚫 كل يوزر يكتب ريفيو واحد بس للكورس
            $table->unique(['user_id', 'course_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('reviews');
    }
}
