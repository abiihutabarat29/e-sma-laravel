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
        Schema::create('guru', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sekolah_id');
            $table->string('jenjang');
            $table->string('nip')->nullable();
            $table->string('nik');
            $table->string('nuptk');
            $table->string('nrg');
            $table->string('nama');
            $table->string('alamat');
            $table->string('tempat_lahir');
            $table->string('tgl_lahir');
            $table->string('gender');
            $table->string('golongan')->nullable();
            $table->string('tingkat');
            $table->string('jurusan');
            $table->string('thnijazah');
            $table->string('agama');
            $table->string('status');
            $table->string('tmtguru');
            $table->string('tmtsekolah');
            $table->string('thnserti')->nullable();
            $table->string('mapel');
            $table->string('j_jam');
            $table->string('mk_thn')->nullable();
            $table->string('mk_bln')->nullable();
            $table->string('tgs_tambah')->nullable();
            $table->string('sts_serti');
            $table->string('mapel_serti')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('no_sk')->nullable();
            $table->string('tgl_sk')->nullable();
            $table->string('nmdiklat')->nullable();
            $table->string('tdiklat')->nullable();
            $table->string('lmdiklat')->nullable();
            $table->string('thndiklat')->nullable();
            $table->string('nohp');
            $table->string('email');
            $table->string('kehadiran')->nullable();
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guru');
    }
};
