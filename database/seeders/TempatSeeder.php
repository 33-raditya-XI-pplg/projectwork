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

                'created_by' => 0,
            ],
            [
                'nama_tempat' => 'Gedung Serbaguna Lhoksumawe',
                'no_telp' => '0334-18056',
                'alamat' => 'Jalan yang berbatu',
                'alamat_kota' => 'Lhoksumawe',
                'link_maps' => 'https://www.google.com/maps/place//@-8.1946681,113.6802083,14.5z?entry=ttu',

                'created_by' => 0,
            ],
            [
                'nama_tempat' => 'Laboratorium Rekayasa Perangkat Lunak',
                'no_telp' => '0334-18057',
                'alamat' => 'Jalan yang halus',
                'alamat_kota' => 'Lumajang',
                'link_maps' => 'https://www.google.com/maps/place/SMK+Negeri+1+Lumajang/@-8.1254897,113.2180274,15z/data=!4m6!3m5!1s0x2dd667897656a9c1:0xa6cd2590433df9d4!8m2!3d-8.1254897!4d113.2180274!16s%2Fg%2F1thknt96?entry=ttu',

                'created_by' => 0,
            ]
        ]);
    }
}
