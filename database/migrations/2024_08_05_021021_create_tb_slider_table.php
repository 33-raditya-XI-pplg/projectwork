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
        Schema::create('tb_slider', function (Blueprint $table) {
            $table->bigIncrements('id_slider');
            // foreign key
            $table->foreignId('page_id')->constrained('tb_page', 'id_page');
            $table->string('title', 255);
            $table->text('description')->nullable();
            $table->string('image_url', 255);
            $table->integer('position');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_slider');
    }
};
