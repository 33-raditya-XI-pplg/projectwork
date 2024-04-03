<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BackgroundSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Background
        DB::table('tb_background')->insert([
            [
                'nama_bg' => 'bg_sertifikasi',
                'orientasi_bg' => 'landscape',
                'path_bg' => 'assets\img\dummy\bg\template_sertifikasi.png',
                'rincian_bg' => 'Background khusus Sertifikasi'
            ],
            [
                'nama_bg' => 'bg_seminar',
                'orientasi_bg' => 'landscape',
                'path_bg' => 'assets\img\dummy\bg\template_seminar.png',
                'rincian_bg' => 'Background khusus Seminar'
            ],
            [
                'nama_bg' => 'bg_piagam_1',
                'orientasi_bg' => 'potrait',
                'path_bg' => 'assets\img\dummy\bg\template_piagam_1.png',
                'rincian_bg' => 'Background khusus Piagam-1'
            ],
            [
                'nama_bg' => 'bg_piagam_2',
                'orientasi_bg' => 'potrait',
                'path_bg' => 'assets\img\dummy\bg\template_piagam_2.png',
                'rincian_bg' => 'Background khusus Piagam-2'
            ]
        ]);
    }
}
