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
            $table->string('nama_event');
            $table->dateTime('tanggal_event');
            $table->string('jenis_event');
            $table->timestamps();

            // Foreign key 
            $table->unsignedBigInteger('id_instansi');
            $table->index('id_instansi');

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
