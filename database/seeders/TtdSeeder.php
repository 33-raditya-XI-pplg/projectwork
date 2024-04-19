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
                'nama_ttd' => 'Agus Hariyanto',
                'jabatan' => 'Penguji Tingkat 1',
                'nomor_induk' => 2020101070,
                'path_ttd' => 'assets\img\dummy\ttd\ttd_agus.png',
                'status' => 'Aktif',

                'created_by' => 0,
            ],
            [
                'instansi_id' => 1,
                'nama_ttd' => 'Denny Wijanarko',
                'jabatan' => 'Penguji Tingkat 1',
                'nomor_induk' => 2020101071,
                'path_ttd' => 'assets\img\dummy\ttd\ttd_denny.png',
                'status' => 'Aktif',

                'created_by' => 0,
            ]
        ]);
    }
}
