<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            // Drop existing foreign key if exists
            $table->dropForeign(['product_id']);
            
            // Add foreign key with cascade delete
            $table->foreign('product_id')
                  ->references('id')
                  ->on('products')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            // Drop the cascade foreign key
            $table->dropForeign(['product_id']);
            
            // Restore original foreign key without cascade
            $table->foreign('product_id')
                  ->references('id')
                  ->on('products');
        });
    }
};
