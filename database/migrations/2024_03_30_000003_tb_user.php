<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('tb_user', function (Blueprint $table) {
            $table->id('id_user');
            // Foreign Key
            $table->foreignId('instansi_id')->nullable()->constrained('tb_instansi', 'id_instansi');

            $table->string('nama_lengkap');
            $table->string('email')->unique();
            $table->string('password');

            $table->integer('nomor_induk')->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->string('path_foto')->nullable();
            $table->text('alamat')->nullable();
            $table->string('alamat_kota')->nullable();
            $table->enum('jenis_kelamin', ['laki-laki', 'perempuan'])->nullable();
            $table->string('no_telp', 20)->nullable(); 

            $table->string('nama_sekolah')->nullable();
            $table->string('jurusan')->nullable();
            $table->string('jenjang')->nullable();
            $table->date('tahun_lulus')->nullable();

            $table->string('nama_perusahaan')->nullable();
            $table->text('alamat_perusahaan')->nullable();
            $table->string('alamat_kota_perusahaan')->nullable();
            $table->string('jabatan_pekerjaan')->nullable();
            $table->string('no_telp_perusahaan', 20)->nullable();

            $table->string('status')->nullable();
            $table->string('level')->nullable();
            $table->string('jabatan_penguji')->nullable();
            $table->string('type_penguji')->nullable();

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
        Schema::dropIfExists('tb_user');
    }
};
