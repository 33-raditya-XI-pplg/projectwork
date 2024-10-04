<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     * 
     * ====PIVOT TABLE====
     * tb_user to tb_event_skema
     */
    public function up()
    {
        Schema::create('tb_peserta', function (Blueprint $table) {
            $table->id('id_peserta');
            // Foreign Key
            $table->foreignId('user_id')->constrained('tb_user', 'id_user')->onDelete('cascade');
            $table->foreignId('event_skema_id')->constrained('tb_event_skema', 'id_event_skema')
                ->onDelete('cascade');

            $table->foreignId('upload_pembayaran_id')->nullable()->constrained('tb_upload_pembayaran', 'id_upload_pembayaran')->onDelete(('cascade'));
            // $table->string('status');

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
        Schema::dropIfExists('tb_peserta');
    }
};
