<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
                'status' => 'Aktif'
            ],
            [
                'nama_skema' => 'Junior Mobile Dev',
                'path_icon' => 'assets\img\dummy\icon_skema\icon_skema_1.png',
                'has_sub_skema' => 1,
                'status' => 'Aktif'
            ],
            [
                'nama_skema' => 'Microsoft Windows',
                'path_icon' => 'assets\img\dummy\icon_skema\icon_skema_2.png',
                'has_sub_skema' => 1,
                'status' => 'Aktif'
            ],
            [
                'nama_skema' => 'Microsoft Office',
                'path_icon' => 'assets\img\dummy\icon_skema\icon_skema_2.png',
                'has_sub_skema' => 1,
                'status' => 'Aktif'
            ]
        ]); 

        DB::table('tb_sub_skema')->insert([
            [
                'skema_id' => 1,
                'judul_sub' => 'Memahami framework laravel'
            ],
            [
                'skema_id' => 1,
                'judul_sub' => 'Mampu membuat CRUD menggunakan laravel'
            ],
            [
                'skema_id' => 2,
                'judul_sub' => 'Memahami framework flutter'
            ],
            [
                'skema_id' => 2,
                'judul_sub' => 'Mampu membuat CRUD menggunakan flutter'
            ],
            [
                'skema_id' => 3,
                'judul_sub' => 'Memahami sistem navigasi windows'
            ],
            [
                'skema_id' => 3,
                'judul_sub' => 'Mampu mengoperasikan windows'
            ],
            [
                'skema_id' => 4,
                'judul_sub' => 'Memahami microsoft word'
            ],
            [
                'skema_id' => 4,
                'judul_sub' => 'Mampu membuat artikel pada microsoft word'
            ]
        ]);
    }
}
