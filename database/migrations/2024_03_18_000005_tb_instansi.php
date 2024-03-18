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
        Schema::create('tb_instansi', function (Blueprint $table) {
            $table->id('id_instansi');
            $table->string('nama_instansi');
            $table->integer('nomor_instansi');
            
            $table->string('nama_kepala_instansi');
            $table->string('jabatan_kepala');

            $table->text('path_logo');
            $table->string('status');

            $table->text('alamat');
            $table->string('alamat_kota');
            $table->string('email')->unique();
            $table->integer('no_telp')->unique();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_instansi');
    }
};
