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
            // Foreign Key
            $table->foreignId('skema_id')->constrained('tb_skema', 'id_skema');

            $table->string('judul_sub');
            $table->integer('nomor_sub');
            $table->text('deskripsi_sub');

            $table->timestamps();
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
