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
        Schema::create('tb_partner', function (Blueprint $table) {
            $table->bigIncrements('id_partner');
            // foreign key
            $table->foreignId('page_id')->constrained('tb_page', 'id_page');
            $table->string('nama_partner', 100);
            $table->string('email_partner', 100);
            $table->string('telepon_partner', 20)->nullable();
            $table->string('alamat_partner', 255)->nullable();
            $table->string('jenis_partner', 50)->nullable();
            $table->date('tanggal_bergabung')->nullable();
            $table->boolean('status_partner')->default(true);
            $table->string('logo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_partner');
    }
};
