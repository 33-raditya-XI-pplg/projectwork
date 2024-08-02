<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tb_kategori')->insert([
            [
                'nama_kategori' => 'Teknologi',
                'deskripsi' => 'Berita dan informasi terbaru seputar teknologi dan inovasi.',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_kategori' => 'Pendidikan',
                'deskripsi' => 'Artikel dan informasi mengenai pendidikan dan pembelajaran.',
                'created_by' => 2,
                'updated_by' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_kategori' => 'Kesehatan',
                'deskripsi' => 'Tips dan berita tentang kesehatan serta gaya hidup sehat.',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_kategori' => 'Olahraga',
                'deskripsi' => 'Informasi terkini tentang dunia olahraga dan pertandingan.',
                'created_by' => 2,
                'updated_by' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_kategori' => 'Bisnis',
                'deskripsi' => 'Berita dan artikel mengenai dunia bisnis dan keuangan.',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
