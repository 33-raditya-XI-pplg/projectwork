<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // public function up(): void
    // {
    //     Schema::create('tb_user', function (Blueprint $table) {
    //         $table->id();
    //         $table->string('name');
    //         $table->string('email');
    //         $table->timestamp('email_verified_at')->nullable();
    //         $table->string('password');
    //         $table->rememberToken();
    //         $table->timestamps();
    //     });
    // }
    public function up()
    {
        Schema::create('tb_user', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('email');
            $table->string('password');
            $table->string('nama_lengkap');
            $table->string('nomor_induk');
            $table->date('tgl_lahir');
            $table->string('tempat_lahir');
            $table->string('pekerjaan')->nullable();
            $table->string('foto')->nullable();
            $table->text('alamat')->nullable();
            $table->string('alamat_kota')->nullable();
            $table->char('jenis_kelamin', 1); 
            $table->string('no_telp')->nullable();
            $table->string('role');
            $table->timestamps(); 

            // Foreign key 
            $table->unsignedBigInteger('id_instansi');
            // $table->foreign('id_instansi');
            $table->index('id_instansi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_user');
    }
};
