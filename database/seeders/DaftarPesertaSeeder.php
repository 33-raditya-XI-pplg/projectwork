<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DaftarPesertaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tb_peserta')->insert([
            [
                'user_id' => 4,
                'event_skema_id' => 1,
                'status' => 'Aktif',

                'created_by' => 0,
            ],
            [
                'user_id' => 5,
                'event_skema_id' => 1,
                'status' => 'Aktif',

                'created_by' => 0,
            ],
            [
                'user_id' => 6,
                'event_skema_id' => 1,
                'status' => 'Aktif',

                'created_by' => 0,
            ],
            [
                'user_id' => 4,
                'event_skema_id' => 2,
                'status' => 'Aktif',

                'created_by' => 0,
            ],
            [
                'user_id' => 5,
                'event_skema_id' => 2,
                'status' => 'Aktif',

                'created_by' => 0,
            ]
        ]);
    }
}
