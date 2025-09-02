<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * ANCHOR: Create products table.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('category_id');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('short_description');
            $table->longText('description');
            $table->longText('specifications');
            $table->longText('care_instructions');
            $table->bigInteger('price');
            $table->string('main_image')->nullable();
            $table->integer('weight')->default(0);
            $table->string('status')->default('active');
            $table->integer('stock')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->timestamps();

            // Add foreign key to categories
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * ANCHOR: Reverse the migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
