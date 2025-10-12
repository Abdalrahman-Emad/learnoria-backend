<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddIndexesToCoursesTable extends Migration
{
    public function up()
    {
        Schema::table('courses', function (Blueprint $table) {
            // Basic indexes
            $table->index('status');
            $table->index('provider_id');
            $table->index('field');
            $table->index('city');
            $table->index('price');
            $table->index('created_at');
            
            // Composite indexes for common query patterns
            $table->index(['status', 'created_at']);
            $table->index(['provider_id', 'status']);
            $table->index(['field', 'city', 'status']);
        });

        // Full-text search index (MySQL only)
        if (config('database.default') === 'mysql') {
            DB::statement('ALTER TABLE courses ADD FULLTEXT fulltext_index (title, description)');
        }
    }

    public function down()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['provider_id']);
            $table->dropIndex(['field']);
            $table->dropIndex(['city']);
            $table->dropIndex(['price']);
            $table->dropIndex(['created_at']);
            $table->dropIndex(['status', 'created_at']);
            $table->dropIndex(['provider_id', 'status']);
            $table->dropIndex(['field', 'city', 'status']);
        });

        if (config('database.default') === 'mysql') {
            DB::statement('ALTER TABLE courses DROP INDEX fulltext_index');
        }
    }
}
