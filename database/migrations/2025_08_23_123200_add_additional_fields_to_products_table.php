<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * ANCHOR: Add additional fields to products table.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Add fields that were in the original migrations
            if (!Schema::hasColumn('products', 'weight')) {
                $table->integer('weight')->default(0)->after('main_image');
            }
            if (!Schema::hasColumn('products', 'status')) {
                $table->string('status')->default('active')->after('weight');
            }
            if (!Schema::hasColumn('products', 'stock')) {
                $table->integer('stock')->default(0)->after('status');
            }
            if (!Schema::hasColumn('products', 'is_featured')) {
                $table->boolean('is_featured')->default(false)->after('stock');
            }
        });
    }

    /**
     * ANCHOR: Reverse the migration.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['weight', 'status', 'stock', 'is_featured']);
        });
    }
};
