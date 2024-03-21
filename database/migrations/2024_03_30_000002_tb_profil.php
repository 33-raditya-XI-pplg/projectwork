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
        Schema::create("tb_profil", function (Blueprint $table) {
            $table->id("id_profil");
            // Foreign Key
            $table->foreignId('page_id')->constrained('tb_page', 'id_page');

            $table->text('tentang_kami');
            $table->string('path_struktur_organisasi');
            $table->text('visi');
            $table->text('misi');
            $table->text('sejarah');

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
        Schema::dropIfExists('tb_profil');
    }
};
