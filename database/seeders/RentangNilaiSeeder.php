<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RentangNilaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Rentang Nilai
        DB::table('tb_rentang_nilai')->insert([
            [
                'nama_konversi_nilai' => 'konversi_abcd',
                'inisial_rentang_nilai' => 'A',
                'keterangan_rentang_nilai' => 'Sangat Kompeten',
                'rentang_atas' => 100,
                'rentang_bawah' => 94,

                'created_by' => 0,
            ],
            [
                'nama_konversi_nilai' => 'konversi_abcd',
                'inisial_rentang_nilai' => 'B',
                'keterangan_rentang_nilai' => 'Cukup Kompeten',
                'rentang_atas' => 93,
                'rentang_bawah' => 84,

                'created_by' => 0,
            ],
            [
                'nama_konversi_nilai' => 'konversi_abcd',
                'inisial_rentang_nilai' => 'C',
                'keterangan_rentang_nilai' => 'Kurang Kompeten',
                'rentang_atas' => 83,
                'rentang_bawah' => 74,

                'created_by' => 0,
            ],
            [
                'nama_konversi_nilai' => 'konversi_abcd',
                'inisial_rentang_nilai' => 'D',
                'keterangan_rentang_nilai' => 'Tidak Kompeten',
                'rentang_atas' => 73,
                'rentang_bawah' => 0,

                'created_by' => 0,
            ],
            [
                'nama_konversi_nilai' => 'konversi_kompeten',
                'inisial_rentang_nilai' => 'Sangat Kompeten',
                'keterangan_rentang_nilai' => 'Sangat Kompeten',
                'rentang_atas' => 100,
                'rentang_bawah' => 90,

                'created_by' => 0,
            ],
            [
                'nama_konversi_nilai' => 'konversi_kompeten',
                'inisial_rentang_nilai' => 'Cukup Kompeten',
                'keterangan_rentang_nilai' => 'Cukup Kompeten',
                'rentang_atas' => 89,
                'rentang_bawah' => 80,
            ],
            [
                'nama_konversi_nilai' => 'konversi_kompeten',
                'inisial_rentang_nilai' => 'Kurang Kompeten',
                'keterangan_rentang_nilai' => 'Kurang Kompeten',
                'rentang_atas' => 79,
                'rentang_bawah' => 60,

                'created_by' => 0,
            ],
            [
                'nama_konversi_nilai' => 'konversi_kompeten',
                'inisial_rentang_nilai' => 'Tidak Kompeten',
                'keterangan_rentang_nilai' => 'Tidak Kompeten',
                'rentang_atas' => 59,
                'rentang_bawah' => 0,

                'created_by' => 0,
            ],
        ]);
    }
}
