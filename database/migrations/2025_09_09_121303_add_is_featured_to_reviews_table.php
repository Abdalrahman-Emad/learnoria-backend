<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsFeaturedToReviewsTable extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('reviews', 'is_featured')) {
            Schema::table('reviews', function (Blueprint $table) {
                $table->boolean('is_featured')->default(false);
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('reviews', 'is_featured')) {
            Schema::table('reviews', function (Blueprint $table) {
                $table->dropColumn('is_featured');
            });
        }
    }
}
