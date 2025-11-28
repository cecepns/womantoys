<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambah kolom image_mobile_path untuk menyimpan versi gambar mobile.
     * Prioritas penggunaan: mobile (jika ada) untuk perangkat mobile, desktop untuk selain itu.
     */
    public function up(): void
    {
        Schema::table('carousel_slides', function (Blueprint $table) {
            $table->string('image_mobile_path')->nullable()->after('image_path');
        });
    }

    /**
     * Rollback perubahan kolom image_mobile_path.
     */
    public function down(): void
    {
        Schema::table('carousel_slides', function (Blueprint $table) {
            $table->dropColumn('image_mobile_path');
        });
    }
};

