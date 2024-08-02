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
        Schema::create('tb_testimoni', function (Blueprint $table) {
            $table->bigIncrements('id_testimoni');
            // foreign key
            $table->foreignId('page_id')->constrained('tb_page', 'id_page');
            $table->string('nama', 100);
            $table->string('email', 100);
            $table->date('tanggal');
            $table->integer('rating')->check('rating >= 1 AND rating <= 5');
            $table->text('isi_testimoni');
            $table->boolean('status_publikasi')->default(false);
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
        Schema::dropIfExists('tb_testimoni');
    }
};
