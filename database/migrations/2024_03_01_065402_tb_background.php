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
        Schema::create('tb_background', function (Blueprint $table) {
            $table->id('id_background');
            $table->string('orientasi_bg');
            $table->integer('has_lampiran');
            $table->string('path_bg');
            $table->string('nama_bg');
            $table->text('rincian_bg')->nullable();
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_background');
    }
};
