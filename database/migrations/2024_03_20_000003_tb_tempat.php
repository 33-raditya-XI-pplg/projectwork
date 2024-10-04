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
        Schema::create("tb_tempat", function (Blueprint $table) {
            $table->id('id_tempat');
            $table->foreignId('page_id')->nullable()->constrained('tb_page', 'id_page')->cascadeOnDelete();
            $table->string('nama_tempat');
            $table->integer('no_telp', 20)->nullable();
            $table->text('alamat');
            $table->string('alamat_kota');
            $table->string('link_maps');


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
        Schema::dropIfExists('tb_tempat');
    }
};
