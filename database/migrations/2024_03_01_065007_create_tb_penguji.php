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
        Schema::create('tb_penguji', function (Blueprint $table) {
            $table->id(); 
            $table->string('nama_penguji');
            $table->string('instansi_penguji');
            $table->string('nomor_induk');
            $table->string('jabatan_penguji');
            $table->string('type_penguji'); 
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_penguji');
    }
};
