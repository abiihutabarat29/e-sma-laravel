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
        Schema::create('profile_sekolah', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sekolah_id');
            $table->unsignedBigInteger('kabupaten_id');
            $table->unsignedBigInteger('kecamatan_id');
            $table->unsignedBigInteger('desa_id');
            $table->string('nss')->unique();
            $table->string('nds')->unique();
            $table->string('nosiop');
            $table->string('akreditas');
            $table->string('thnberdiri');
            $table->string('nosk');
            $table->string('tglsk');
            $table->string('standar');
            $table->string('waktub');
            $table->string('alamat');
            $table->string('kodepos');
            $table->string('telp');
            $table->string('email');
            $table->string('website')->nullable();
            $table->string('nip')->nullable();
            $table->string('kepsek');
            $table->string('foto_kepsek')->nullable();
            $table->string('namayss')->nullable();
            $table->string('alamatyss')->nullable();
            $table->string('gmap')->nullable();
            $table->string('foto_sekolah')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile_sekolah');
    }
};
