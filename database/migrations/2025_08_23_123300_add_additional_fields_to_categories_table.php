<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * ANCHOR: Add additional fields to categories table.
     */
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            // Add fields that were in the original migrations
            if (!Schema::hasColumn('categories', 'cover_image')) {
                $table->string('cover_image')->nullable()->after('slug');
            }
        });
    }

    /**
     * ANCHOR: Reverse the migration.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('cover_image');
        });
    }
};
