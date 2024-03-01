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
        Schema::create('tb_sub_skema', function (Blueprint $table) {
            $table->id('id_sub_skema');
            $table->string('judul_sub');
            $table->string('nomor_sub');
            $table->text('deskripsi_sub');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_sub_skema');
    }
};
