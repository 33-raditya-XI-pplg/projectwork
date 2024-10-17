<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tb_kemampuan_dasar', function (Blueprint $table) {
            $table->id('id_kemampuan_dasar');
            // Foreign Key
            $table->foreignId('laporan_perkembangan_id')->constrained('tb_laporan_perkembangan', 'id_laporan_perkembangan')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->string('kemampuan');
            $table->string('keterangan');

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
        Schema::dropIfExists('tb_sub_skema');
    }
};
