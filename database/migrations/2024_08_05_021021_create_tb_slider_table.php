<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tb_slider', function (Blueprint $table) {
            $table->bigIncrements('id_slider');
            // Foreign key
            $table->foreignId('page_id')->constrained('tb_page', 'id_page')->cascadeOnDelete();
            $table->string('title', 255);
            $table->text('description')->nullable();
            $table->string('image_url', 255);
            $table->integer('position');
            $table->boolean('status')->nullable(); // Updated to boolean and nullable
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
