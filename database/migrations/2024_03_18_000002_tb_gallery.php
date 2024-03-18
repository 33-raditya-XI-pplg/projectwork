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
        Schema::create('tb_gallery', function (Blueprint $table) {
            $table->id('id_gallery');
            $table->string('nama');
            $table->string('path_logo');
            $table->enum('kategori', ['partner', 'klien'])->default('klien');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_gallery');
    }
};
