<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * ANCHOR: Create orders table.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('order_number')->unique();
            $table->string('confirmation_token')->unique();
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('customer_email');
            $table->text('shipping_address');
            $table->string('shipping_method');
            $table->bigInteger('shipping_cost');
            $table->bigInteger('total_amount');
            $table->string('status');
            $table->string('payment_proof_path')->nullable();
            $table->string('voucher_code')->nullable();
            $table->bigInteger('voucher_discount')->default(0);
            $table->timestamps();
        });
    }

    /**
     * ANCHOR: Reverse the migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
