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
        Schema::create('tb_galeri', function (Blueprint $table) {
            $table->id('id_galeri');
            // Foreign Key
            $table->foreignId('page_id')->constrained('tb_page', 'id_page');

            $table->string('nama');
            $table->string('path_file');
            $table->enum('kategori', ['partner', 'klien', 'gambar', 'video']);
            $table->string('deskripsi')->nullable();
            
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
        Schema::dropIfExists('tb_galeri');
    }
};
