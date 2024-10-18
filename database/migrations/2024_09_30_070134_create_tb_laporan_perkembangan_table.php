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
        Schema::create('tb_laporan_perkembangan', function (Blueprint $table) {
            $table->id('id_laporan_perkembangan');

            // Foreign Keys
            $table->foreignId('event_skema_id')->constrained('tb_event_skema', 'id_event_skema')->cascadeOnDelete();
            // $table->foreignId('sub_skema_id')->constrained('tb_sub_skema', 'id_sub_skema')->cascadeOnDelete();
            $table->foreignId('peserta_id')->constrained('tb_peserta', 'id_peserta')->cascadeOnDelete();

            // Fields
            // $table->foreignId('kemampuan_dasar_id')->constrained('tb_kemampuan_dasar', 'id_kemampuan_dasar')->cascadeOnDelete();
            $table->date('tanggal_penilaian');
            $table->string('catatan');
            $table->text('pengalaman_anak');
            $table->text('peralatan_penunjang');
            $table->text('saran');


            // Metadata
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
        Schema::dropIfExists('tb_laporan_perkembangan');
    }
};
