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
        Schema::create('tb_event_skema', function (Blueprint $table) {
            $table->id('id_event_skema');

            // Foreign key
            $table->unsignedBigInteger('id_event');
            $table->unsignedBigInteger('id_skema');
            $table->unsignedBigInteger('id_background');
            $table->index('id_event');
            $table->index('id_skema');
            $table->index('id_background');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_event_skema');
    }
};
