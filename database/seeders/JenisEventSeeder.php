<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisEventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Jenis Event
        DB::table('tb_jenis_event')->insert([
            [
                'nama_jenis_event' => 'Sertifikasi',
                'has_lampiran' => 1,
                'deskripsi' => 'Acara sertifikasi yang diadakan oleh lembaga sertifikasi',
                'status' => 'Aktif',

                'created_by' => 0,
            ],
            [
                'nama_jenis_event' => 'Seminar',
                'has_lampiran' => 0,
                'deskripsi' => 'Acara multitema yang diadakan oleh suatu instansi',
                'status' => 'Aktif',

                'created_by' => 0,
            ]
        ]);
    }
}
