<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Mengisi tabel page dengan data sampel
        DB::table('tb_page')->insert([
            [
                'id_page' => 1,
                'nama_page' => 'Halaman LPK',
                'deskripsi' => 'Halaman utama LPK',
                'pindah_halaman' => 'https://lpk.mascitra.cloud/',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_page' => 2,
                'nama_page' => 'Halaman LSP',
                'deskripsi' => 'Halaman Utama LSP',
                'pindah_halaman' => 'https://lsp.mascitra.cloud/beranda',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // Tambahkan data lain jika diperlukan
        ]);
    }
}
