<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * ANCHOR: Add voucher fields to orders table.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->bigInteger('subtotal')->after('shipping_cost')->default(0);
            $table->bigInteger('discount_amount')->after('subtotal')->default(0);
            $table->unsignedBigInteger('voucher_id')->nullable()->after('discount_amount');
            $table->foreign('voucher_id')->references('id')->on('vouchers')->onDelete('set null');
        });
    }

    /**
     * ANCHOR: Remove voucher fields from orders table.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Check if foreign key exists before dropping
            $foreignKeys = Schema::getConnection()
                ->getDoctrineSchemaManager()
                ->listTableForeignKeys('orders');
            
            $foreignKeyName = 'orders_voucher_id_foreign';
            if (collect($foreignKeys)->contains('name', $foreignKeyName)) {
                $table->dropForeign($foreignKeyName);
            }
            
            $table->dropColumn(['subtotal', 'discount_amount', 'voucher_id']);
        });
    }
};

