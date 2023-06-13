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
        Schema::create('inventaris_sekolah', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sekolah_id');
            $table->unsignedBigInteger('inventaris_id');
            $table->string('dibutuhkan');
            $table->string('ada');
            $table->string('kurang');
            $table->string('lebih');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventaris_sekolah');
    }
};
