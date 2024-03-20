<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * ====PIVOT TABLE====
     * tb_kategori to tb_blog
     */
    public function up() 
    {
        Schema::create('tb_blog_kategori', function (Blueprint $table) {
            $table->id('id_blog_kategori');
            // Foreign Key
            $table->foreignId('blog_id')->constrained('tb_blog', 'id_blog');
            $table->foreignId('kategori_id')->constrained('tb_kategori', 'id_kategori');

            $table->integer('created_by');
            $table->integer('updated_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_blog_kategori');
    }
};
