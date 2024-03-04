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
        Schema::create('tb_log', function (Blueprint $table) {
            $table->id('id_log');
            $table->timestamp('login_time');
            $table->timestamps();

            // Foreign key
            $table->unsignedBigInteger('id_user');
            $table->index('id_user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_log');
    }
};
