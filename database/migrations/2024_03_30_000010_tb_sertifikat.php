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
            $table->foreignId('user_id')->constrained('tb_user', 'id_user');
            $table->foreignId('event_skema_id')->constrained('tb_event_skema', 'id_event_skema');

            $table->integer('nomor_sertifikat');
            $table->date('tgl_terbit');
            $table->integer('masa_berlaku');
            $table->text('keterangan');
            $table->string('status');

            $table->integer('total_nilai');
            $table->integer('inisial_nilai');

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
