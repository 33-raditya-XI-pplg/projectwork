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
        Schema::create('tb_ttd', function (Blueprint $table) {
            $table->id('id_ttd');
            $table->string('nama_ttd');
            $table->string('jabatan');
            $table->string('nomor_induk');
            $table->unsignedBigInteger('id_instansi')->nullable();
            $table->index('id_instansi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_ttd');
    }
};
