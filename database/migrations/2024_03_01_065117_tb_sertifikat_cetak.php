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
        Schema::create('tb_sertifikat_cetak', function (Blueprint $table) {
            $table->id('id_sertifikat_cetak');
            $table->string('path_file');
            $table->timestamps(); 

            // Foreign key 
            $table->unsignedBigInteger('id_sertifikat');
            $table->index('id_sertifikat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_sertifikat_cetak');
    }
};
