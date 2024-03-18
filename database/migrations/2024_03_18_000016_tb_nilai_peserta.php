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
            $table->id('id_nilai_peserta');
            // Foreign Key
            $table->foreignId('user_id')->constrained('tb_user', 'id_user');
            $table->foreignId('sub_skema_id')->constrained('tb_sub_skema', 'id_sub_skema');
            $table->foreignId('event_skema_id')->constrained('tb_event_skema', 'id_event_skema');

            $table->integer('nilai');
            $table->string('status');

            $table->timestamps();
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
