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
        Schema::create('profile_cabdis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('users_cabdis_id')->unique();
            $table->foreign('users_cabdis_id')
                ->references('id')
                ->on('users_cabdis')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->string('nama');
            $table->string('email');
            $table->string('nik');
            $table->string('tempat_lahir')->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->string('gender')->nullable();
            $table->string('nohp');
            $table->string('alamat')->nullable();
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile_cabdis');
    }
};
