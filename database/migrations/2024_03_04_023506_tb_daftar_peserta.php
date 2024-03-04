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
        Schema::create('tb_daftar_peserta', function (Blueprint $table) {
            $table->id('id_daftar_peserta');
            $table->timestamp('timestamp');

            // Foreign key
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_event_skema');
            $table->index('id_user');
            $table->index('id_event_skema');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_daftar_peserta');
    }
};
