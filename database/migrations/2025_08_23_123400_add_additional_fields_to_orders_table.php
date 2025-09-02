<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * ANCHOR: Add additional fields to orders table.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Add fields that were in the original migrations
            if (!Schema::hasColumn('orders', 'voucher_code')) {
                $table->string('voucher_code')->nullable()->after('payment_proof_path');
            }
            if (!Schema::hasColumn('orders', 'voucher_discount')) {
                $table->bigInteger('voucher_discount')->default(0)->after('voucher_code');
            }
        });
    }

    /**
     * ANCHOR: Reverse the migration.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['voucher_code', 'voucher_discount']);
        });
    }
};
