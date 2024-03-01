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
        Schema::create('tb_skema', function (Blueprint $table) {
            $table->id('id_skema');
            $table->unsignedBigInteger('id_sub_skema')->nullable();
            $table->string('nama_skema');
            $table->text('deskripsi_skema')->nullable();
            $table->boolean('has_sub_skema')->default(false);
            $table->index('id_sub_skema');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_skema');
    }
};
