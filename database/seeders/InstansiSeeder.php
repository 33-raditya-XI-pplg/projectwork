<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InstansiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Instansi
        DB::table('tb_instansi')->insert([
            [
                'nama_instansi' => 'Politeknik Negeri Jember',
                'nomor_instansi' => 430,
                'nama_kepala_instansi' => 'Purwanto',
                'jabatan_kepala' => 'Pembina Tingkat 1',
                'path_logo' => 'assets\img\icon.png',
                'status' => 'Aktif',
                'alamat' => 'Jalan yang termasuk benar',
                'alamat_kota' => 'KABUPATEN PROBOLINGGO',
                'email' => 'polije@gmail.com',
                'no_telp' => '033418045',

                'created_by' => 0,
            ],
            [
                'nama_instansi' => 'Politeknik Negeri Lhoksumawe',
                'nomor_instansi' => 431,
                'nama_kepala_instansi' => 'Sunarwito',
                'jabatan_kepala' => 'Direktur',
                'path_logo' => 'assets\img\icon.png',
                'status' => 'Aktif',
                'alamat' => 'Jalan yang termasuk salah',
                'alamat_kota' => 'KABUPATEN PASURUAN',
                'email' => 'sumawe@gmail.com',
                'no_telp' => '033418046',

                'created_by' => 0,
            ],
            [
                'nama_instansi' => 'SMKN 1 Satelite',
                'nomor_instansi' => 432,
                'nama_kepala_instansi' => 'Subroto',
                'jabatan_kepala' => 'Kepala Sekolah',
                'path_logo' => 'assets\img\icon.png',
                'status' => 'Aktif',
                'alamat' => 'Jalan yang mepet sawah',
                'alamat_kota' => 'KABUPATEN MOJOKERTO',
                'email' => 'satelite@gmail.com',
                'no_telp' => '033418047',

                'created_by' => 0,
            ]
        ]);
    }
}

