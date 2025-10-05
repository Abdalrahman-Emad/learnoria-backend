<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseCouponsTable extends Migration
{
    public function up()
    {
        Schema::create('course_coupons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->string('code')->unique();
            $table->string('name'); // Coupon display name
            $table->enum('type', ['percentage', 'fixed']); // discount type
            $table->decimal('value', 8, 2); // discount value (percentage or amount)
            $table->integer('usage_limit')->nullable(); // max uses
            $table->integer('used_count')->default(0); // current usage
            $table->datetime('starts_at');
            $table->datetime('expires_at');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('course_coupons');
    }
}
