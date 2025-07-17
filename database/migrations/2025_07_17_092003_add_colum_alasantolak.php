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
        Schema::table('tb_upload_pembayaran', function (Blueprint $table) {
            $table->text('alasan')->nullable()->after('status_pembayaran');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_upload_pembayaran', function (Blueprint $table) {
            $table->dropColumn('alasan');
        });
    }
};
