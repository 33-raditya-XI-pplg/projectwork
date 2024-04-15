<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Event
        DB::table('tb_event')->insert([
            [
                'instansi_id' => 1,
                'tempat_id' => 1,
                'jenis_event_id' => 1,
                'nama_event' => 'Uji Komputer',
                'tgl_mulai' => '2024-04-3',
                'tgl_berakhir' => '2024-04-30',
                'biaya_regis' => 500000,
                'path_banner' => 'assets\img\dummy\banner_event\banner_1.png',
                'deskripsi' => 'Uji komputer diadakan oleh Badan LSP Polije',
                'status' => 'Aktif',
                'visibilitas' => 'publik',

                'created_by' => 0,
            ],
            [
                'instansi_id' => 1,
                'tempat_id' => 1,
                'jenis_event_id' => 1,
                'nama_event' => 'Uji Kompetensi',
                'tgl_mulai' => '2024-04-3',
                'tgl_berakhir' => '2024-04-30',
                'biaya_regis' => 300000,
                'path_banner' => 'assets\img\dummy\banner_event\banner_2.png',
                'deskripsi' => 'Uji kompetensi profesi diadakan oleh Badan LSP Polije',
                'status' => 'Aktif',
                'visibilitas' => 'publik',

                'created_by' => 0,
            ]
        ]);
    }
}
