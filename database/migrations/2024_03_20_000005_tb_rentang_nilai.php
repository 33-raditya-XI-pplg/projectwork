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
        Schema::create('tb_rentang_nilai', function (Blueprint $table) {
            $table->id('id_rentang_nilai');
            $table->string('nama_konversi_nilai');
            $table->string('inisial_rentang_nilai');
            $table->string('keterangan_rentang_nilai');
            $table->string('keterangan');
            
            $table->float('rentang_atas', 8, 1);
            $table->float('rentang_bawah', 8, 1);

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
        Schema::dropIfExists('tb_rentang_nilai');
    }
};
