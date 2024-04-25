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
        Schema::create('tb_menguji', function (Blueprint $table) {
            $table->id('id_menguji');
            // Foreign Key
            $table->foreignId('event_skema_id')->constrained('tb_event_skema', 'id_event_skema')
                  ->onDelete('cascade');
            $table->foreignId('user_id')->constrained('tb_user', 'id_user');

            $table->date('tgl_event');

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
        Schema::dropIfExists('tb_menguji');
    }
};
