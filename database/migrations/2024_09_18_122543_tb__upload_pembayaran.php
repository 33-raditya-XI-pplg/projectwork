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
        Schema::create('tb_upload_pembayaran', function (Blueprint $table) {
            $table->id('id_upload_pembayaran');
            $table->foreignId('event_skema_id')->constrained('tb_event_skema', 'id_event_skema')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('tb_user', 'id_user')->onDelete(('cascade'));
            $table->string('status_pembayaran')->default('Belum Dibayar');
            $table->string('bukti_pembayaran')->nullable();
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
        Schema::dropIfExists('tb_upload_pembayaran');
    }
};
