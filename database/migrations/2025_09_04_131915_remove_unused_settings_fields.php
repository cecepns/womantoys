<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Remove unused settings from the database
        DB::table('settings')->whereIn('key', ['store_province_id', 'store_city_id'])->delete();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Re-insert the removed settings with empty values (for rollback)
        DB::table('settings')->insert([
            [
                'key' => 'store_province_id',
                'value' => '',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'store_city_id',
                'value' => '',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
};
