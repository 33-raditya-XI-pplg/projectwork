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
        Schema::create("tb_blog", function (Blueprint $table) {
            $table->id('id_blog');
            // Foreign Key
            $table->foreignId('user_id')->constrained('tb_user', 'id_user');
            $table->foreignId('page_id')->constrained('tb_page', 'id_page');
            $table->foreignId('kategori_id')->constrained('tb_kategori', 'id_kategori');

            $table->string('judul');
            $table->string('slug')->unique();
            $table->text('ringkasan');
            $table->text('body');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_blog');
    }
};
