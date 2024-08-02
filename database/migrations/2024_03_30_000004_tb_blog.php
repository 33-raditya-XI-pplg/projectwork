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
        Schema::create("tb_blog", function (Blueprint $table) {
            $table->id('id_blog');
            // Foreign Key
            $table->foreignId('page_id')->constrained('tb_page', 'id_page');

            $table->string('judul');
            $table->string('slug')->unique();
            // $table->text('ringkasan');
            $table->text('body');

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
        Schema::dropIfExists('tb_blog');
    }
};
