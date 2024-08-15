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
    Schema::create('tb_faq', function (Blueprint $table) {
        $table->id('id_faq');
        // Foreign Key
        $table->foreignId('page_id')->constrained('tb_page', 'id_page');

        $table->string('pertanyaan');
        $table->string('jawaban');

        $table->integer('created_by')->nullable();
        $table->integer('updated_by')->nullable();
        $table->string('status')->nullable(); // Add this line
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_faq');
    }
};
