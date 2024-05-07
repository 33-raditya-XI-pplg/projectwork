<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TtdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // TTD
        DB::table('tb_ttd')->insert([
            [
                'instansi_id' => 1,
                'nama_ttd' => 'Saiful Anwar',
                'jabatan' => 'Direktur PN',
                'nomor_induk' => 2020101070,
                'path_ttd' => 'assets\img\dummy\ttd\ttd_saiful.png',
                'status' => 'Aktif',

                'created_by' => 0,
            ],
            [
                'instansi_id' => 1,
                'nama_ttd' => 'Surateno',
                'jabatan' => 'Wadir Bidang Wejangan',
                'nomor_induk' => 2020101071,
                'path_ttd' => 'assets\img\dummy\ttd\ttd_surateno.png',
                'status' => 'Aktif',

                'created_by' => 0,
            ]
        ]);
    }
}
