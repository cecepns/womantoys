<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * ANCHOR: Create categories table.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('main_category_id')->nullable();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('cover_image')->nullable();
            $table->timestamps();

            // Add foreign key to main_categories
            $table->foreign('main_category_id')->references('id')->on('main_categories')->onDelete('set null');
        });
    }

    /**
     * ANCHOR: Reverse the migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
