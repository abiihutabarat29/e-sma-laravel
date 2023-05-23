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
        Schema::create('siswa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sekolah_id');
            $table->string('nisn')->unique();
            $table->string('nama');
            $table->string('alamat');
            $table->string('tempat_lahir');
            $table->string('tgl_lahir');
            $table->string('gender');
            $table->string('agama');
            $table->string('kelas');
            $table->string('jurusan');
            $table->string('pkeahlian')->nullable();
            $table->string('nohp');
            $table->string('email');
            $table->string('program_pip')->nullable();
            $table->string('tahun_masuk');
            $table->string('asal_sekolah')->nullable();
            $table->string('no_surat')->nullable();
            $table->string('sts_siswa');
            $table->string('keterangan')->nullable();
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};
