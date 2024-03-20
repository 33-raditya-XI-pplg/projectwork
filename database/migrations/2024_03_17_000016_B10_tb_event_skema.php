<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('tb_event_skema', function (Blueprint $table) {
            $table->id('id_event_skema');
            // Foreign Key
            $table->foreignId('event_id')->constrained('tb_event', 'id_event');
            $table->foreignId('skema_id')->constrained('tb_skema', 'id_skema');
            $table->foreignId('background_id')->constrained('tb_background', 'id_background');

            $table->string('status');

            $table->integer('created_by');
            $table->integer('updated_by');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('tb_event_skema');
    }
};
