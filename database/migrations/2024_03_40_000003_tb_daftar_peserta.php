<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * ====PIVOT TABLE====
     * tb_user to tb_event_skema
     */
    public function up() 
    {
        Schema::create('tb_daftar_peserta', function (Blueprint $table) {
            $table->id('id_daftar_peserta');
            // Foreign Key
            $table->foreignId('user_id')->constrained('tb_user', 'id_user');
            $table->foreignId('event_skema_id')->constrained('tb_event_skema', 'id_event_skema');

            $table->string('status');

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
        Schema::dropIfExists('tb_daftar_peserta');
    }
};
