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
        Schema::create('tb_sertifikat', function (Blueprint $table) {
            $table->id('id_sertifikat');
            $table->string('nomor_sertifikat');
            $table->date('tanggal_terbit');
            $table->date('masa_berlaku');
            $table->string('keterangan')->nullable();
            $table->timestamps(); 

            // Foreign key 
            $table->unsignedBigInteger('id_event_skema'); 
            $table->unsignedBigInteger('id_user'); 
            $table->index('id_event_skema');
            $table->index('id_user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_sertifikat');
    }
};
