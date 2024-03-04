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
        Schema::create('tb_menguji', function (Blueprint $table) {
            $table->id('id_menguji');
            $table->date('tanggal_event');

            // Non FK
            $table->unsignedBigInteger('id_penguji');   
            $table->unsignedBigInteger('id_event_skema');
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
