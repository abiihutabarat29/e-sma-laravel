<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bangunan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sekolah_id');
            $table->string('luas_tanah');
            $table->string('luas_bangunan');
            $table->string('luas_rpembangunan');
            $table->string('luas_halaman')->nullable();
            $table->string('luas_lapangan')->nullable();
            $table->string('luas_kosong')->nullable();
            $table->string('status_tanah');
            $table->string('status_gedung');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bangunan');
    }
};
