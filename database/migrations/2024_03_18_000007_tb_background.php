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
            $table->string('nama_bg');

            $table->enum('orientasi_bg', ['potrait', 'landscape'])->nullable();
            $table->string('path_bg');
            $table->boolean('has_lampiran')->default(false);
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
