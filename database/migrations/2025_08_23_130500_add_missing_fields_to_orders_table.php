<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * ANCHOR: Add missing fields to orders table for voucher support.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Add subtotal field if it doesn't exist
            if (!Schema::hasColumn('orders', 'subtotal')) {
                $table->bigInteger('subtotal')->after('shipping_cost')->default(0);
            }
            
            // Add discount_amount field if it doesn't exist
            if (!Schema::hasColumn('orders', 'discount_amount')) {
                $table->bigInteger('discount_amount')->after('subtotal')->default(0);
            }
            
            // Add voucher_id field if it doesn't exist
            if (!Schema::hasColumn('orders', 'voucher_id')) {
                $table->unsignedBigInteger('voucher_id')->nullable()->after('discount_amount');
                $table->foreign('voucher_id')->references('id')->on('vouchers')->onDelete('set null');
            }
        });
    }

    /**
     * ANCHOR: Remove added fields from orders table.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'voucher_id')) {
                $table->dropForeign(['voucher_id']);
                $table->dropColumn('voucher_id');
            }
            
            if (Schema::hasColumn('orders', 'discount_amount')) {
                $table->dropColumn('discount_amount');
            }
            
            if (Schema::hasColumn('orders', 'subtotal')) {
                $table->dropColumn('subtotal');
            }
        });
    }
};
