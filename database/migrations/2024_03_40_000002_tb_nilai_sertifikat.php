<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * ====PIVOT TABLE====
     * tb_sertifikat to tb_nilai_peserta
     */
    public function up() 
    {
        Schema::create('tb_nilai_sertifikat', function (Blueprint $table) {
            $table->id('id_nilai_sertifikat');
            // Foreign Key
            $table->foreignId('sertifikat_id')->constrained('tb_sertifikat', 'id_sertifikat');
            $table->foreignId('nilai_peserta_id')->constrained('tb_nilai_peserta', 'id_nilai_peserta');

            $table->integer('created_by');
            $table->integer('updated_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_nilai_sertifikat');
    }
};
