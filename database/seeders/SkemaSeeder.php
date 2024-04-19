<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SkemaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Skema
        DB::table('tb_skema')->insert([
            [
                'nama_skema' => 'Junior Web Dev',
                'path_icon' => 'assets\img\dummy\icon_skema\icon_skema_1.png',
                'has_sub_skema' => 1,
                'status' => 'Aktif',

                'created_by' => 0,
            ],
            [
                'nama_skema' => 'Junior Mobile Dev',
                'path_icon' => 'assets\img\dummy\icon_skema\icon_skema_1.png',
                'has_sub_skema' => 1,
                'status' => 'Aktif',

                'created_by' => 0,
            ],
            [
                'nama_skema' => 'Microsoft Windows',
                'path_icon' => 'assets\img\dummy\icon_skema\icon_skema_2.png',
                'has_sub_skema' => 1,
                'status' => 'Aktif',

                'created_by' => 0,
            ],
            [
                'nama_skema' => 'Microsoft Office',
                'path_icon' => 'assets\img\dummy\icon_skema\icon_skema_2.png',
                'has_sub_skema' => 1,
                'status' => 'Aktif',

                'created_by' => 0,
            ],
            [
                'nama_skema' => 'UKK Jurusan RPL',
                'path_icon' => 'assets\img\dummy\icon_skema\icon_skema_2.png',
                'has_sub_skema' => 1,
                'status' => 'Aktif',

                'created_by' => 0,
            ],
            [
                'nama_skema' => 'UKK Jurusan TKJ',
                'path_icon' => 'assets\img\dummy\icon_skema\icon_skema_2.png',
                'has_sub_skema' => 1,
                'status' => 'Aktif',

                'created_by' => 0,
            ]
        ]); 

        DB::table('tb_sub_skema')->insert([
            [
                'skema_id' => 1,
                'judul_sub' => 'Memahami framework laravel',

                'created_by' => 0,
            ],
            [
                'skema_id' => 1,
                'judul_sub' => 'Mampu membuat CRUD menggunakan laravel',

                'created_by' => 0,
            ],
            [
                'skema_id' => 2,
                'judul_sub' => 'Memahami framework flutter',

                'created_by' => 0,
            ],
            [
                'skema_id' => 2,
                'judul_sub' => 'Mampu membuat CRUD menggunakan flutter',

                'created_by' => 0,
            ],
            [
                'skema_id' => 3,
                'judul_sub' => 'Memahami sistem navigasi windows',

                'created_by' => 0,
            ],
            [
                'skema_id' => 3,
                'judul_sub' => 'Mampu mengoperasikan windows',

                'created_by' => 0,
            ],
            [
                'skema_id' => 4,
                'judul_sub' => 'Memahami microsoft word',

                'created_by' => 0,
            ],
            [
                'skema_id' => 4,
                'judul_sub' => 'Mampu membuat artikel pada microsoft word',

                'created_by' => 0,
            ],
            [
                'skema_id' => 5,
                'judul_sub' => 'Memahami Konsep DSA dan CRUD dalam suatu website',

                'created_by' => 0,
            ],
            [
                'skema_id' => 5,
                'judul_sub' => 'Mampu membuat CRUD website menggunakan php native',

                'created_by' => 0,
            ],
            [
                'skema_id' => 6,
                'judul_sub' => 'Memahami Konsep Internet Protocol dan Routing jaringan',

                'created_by' => 0,
            ],
            [
                'skema_id' => 6,
                'judul_sub' => 'Mampu mensimulasikan konsep Vlan dalam Packet-Tracer',

                'created_by' => 0,
            ]
        ]);
    }
};
