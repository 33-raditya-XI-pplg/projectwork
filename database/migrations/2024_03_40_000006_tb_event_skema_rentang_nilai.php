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
     * tb_event_skema to tb_rentang_nilai
     */
    public function up() 
    {
        Schema::create('tb_event_skema_rentang_nilai', function (Blueprint $table) {
            $table->id('id_event_skema_rentang_nilai');
            // Foreign Key
            $table->foreignId('rentang_nilai_id')->constrained('tb_rentang_nilai', 'id_rentang_nilai');
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
        Schema::dropIfExists('tb_event_skema_rentang_nilai');
    }
};
