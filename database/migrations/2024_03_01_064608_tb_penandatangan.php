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
        Schema::create('tb_penandatangan', function (Blueprint $table) {
            $table->id('id_penandatangan');

            // Foreign Key
            $table->unsignedBigInteger('id_event_skema');
            $table->unsignedBigInteger('id_ttd');
            $table->index('id_event_skema');
            $table->index('id_ttd');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_penandatangan');
    }
};
