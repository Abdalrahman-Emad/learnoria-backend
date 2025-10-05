<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWishlistsTable extends Migration
{
    public function up()
    {
        Schema::create('wishlists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            // Prevent duplicate wishlist entries
            $table->unique(['user_id', 'course_id']);
            
            // Add indexes for better performance
            $table->index(['user_id', 'created_at']);
            $table->index(['course_id', 'created_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('wishlists');
    }
}