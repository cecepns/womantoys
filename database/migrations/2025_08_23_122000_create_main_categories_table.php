<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * ANCHOR: Create main categories table.
     */
    public function up(): void
    {
        Schema::create('main_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('cover_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * ANCHOR: Reverse the migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('main_categories');
    }
};
