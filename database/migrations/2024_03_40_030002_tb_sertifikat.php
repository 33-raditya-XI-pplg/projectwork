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
            // Foreign Key
            $table->foreignId('peserta_id')->constrained('tb_peserta', 'id_peserta');
            $table->foreignId('event_skema_id')->constrained('tb_event_skema', 'id_event_skema');

            $table->string('nomor_sertifikat');

            $table->date('tgl_terbit'); 
            $table->date('tgl_berakhir'); 

            $table->string('masa_berlaku'); 
            $table->string('keterangan')->nullable(); 
            // $table->string('status');

            $table->integer('nilai')->nullable(); 
            $table->string('inisial_nilai')->nullable(); 

            $table->integer('created_by')->nullable(); 
            $table->integer('updated_by')->nullable(); 
            $table->timestamps(); 
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
