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
        Schema::create("tb_tempat", function (Blueprint $table) {
            $table->id('id_tempat');
            $table->string('nama_tempat');
            $table->string('no_telp', 20)->nullable(); 
            $table->text('alamat');
            $table->string('alamat_kota');
            $table->string('link_maps');
            
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
        Schema::dropIfExists('tb_tempat');
    }
};
