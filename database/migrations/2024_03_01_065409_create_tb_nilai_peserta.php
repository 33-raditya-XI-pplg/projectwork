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
        Schema::create('tb_nilai_peserta', function (Blueprint $table) {
            $table->id('id_nilai');
    $table->unsignedBigInteger('id_user');
    $table->unsignedBigInteger('id_event');
    $table->unsignedBigInteger('id_sub_skema');
    $table->float('nilai');
    $table->timestamp('timestamp');
    $table->index('id_user');
    $table->index('id_event');
    $table->index('id_sub_skema');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_nilai_peserta');
    }
};
