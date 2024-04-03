<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TempatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tempat
        DB::table('tb_tempat')->insert([
            [
                'nama_tempat' => 'Gedung Sertifikasi LSP Polije',
                'no_telp' => '0334-18055',
                'alamat' => 'Jalan yang keras',
                'alamat_kota' => 'Jember',
                'link_maps' => 'https://www.google.com/maps/place//@-8.1939106,113.679965,15z/data=!3m1!4b1?entry=ttu',
            ],
            [
                'nama_tempat' => 'Gedung Serbaguna Lhoksumawe',
                'no_telp' => '0334-18056',
                'alamat' => 'Jalan yang berbatu',
                'alamat_kota' => 'Lhoksumawe',
                'link_maps' => 'https://www.google.com/maps/place//@-8.1946681,113.6802083,14.5z?entry=ttu',
            ]
        ]);
    }
}
