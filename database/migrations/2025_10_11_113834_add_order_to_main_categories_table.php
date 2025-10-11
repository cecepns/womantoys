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
        Schema::table('main_categories', function (Blueprint $table) {
            $table->integer('order')->default(0)->after('cover_image');
        });

        // Set order for existing records based on created_at
        $mainCategories = DB::table('main_categories')
            ->orderBy('created_at', 'asc')
            ->get();
        
        foreach ($mainCategories as $index => $category) {
            DB::table('main_categories')
                ->where('id', $category->id)
                ->update(['order' => $index + 1]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('main_categories', function (Blueprint $table) {
            $table->dropColumn('order');
        });
    }
};
