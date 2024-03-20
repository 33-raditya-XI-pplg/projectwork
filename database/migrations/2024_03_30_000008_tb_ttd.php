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
            // Foreign Key
            $table->foreignId('instansi_id')->constrained('tb_instansi', 'id_instansi');
            
            $table->string('nama_ttd');
            $table->string('jabatan');
            $table->integer('nomor_induk'); 

            $table->string('path_ttd');
            $table->string('status');

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
        Schema::dropIfExists('tb_ttd');
    }
};
