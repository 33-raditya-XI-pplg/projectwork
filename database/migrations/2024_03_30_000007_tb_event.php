<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('tb_event', function (Blueprint $table) {
            $table->id('id_event');
            // Foreign Key
            $table->foreignId('instansi_id')->constrained('tb_instansi', 'id_instansi');
            $table->foreignId('tempat_id')->constrained('tb_tempat', 'id_tempat');

            $table->string('nama_event');
            $table->date('tgl_mulai');
            $table->date('tgl_berakhir');

            $table->integer('biaya_regis');
            $table->string('path_icon');
            $table->string('path_banner');

            $table->string('jenis_event');
            $table->string('status');

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
        Schema::dropIfExists('tb_event');
    }
};
