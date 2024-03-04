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
            $table->string('nomor_instansi');
            $table->string('nama_kepala_instansi');
            $table->string('jabatan_kepala');
            $table->text('logo')->nullable();
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
