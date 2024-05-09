<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class NilaiPesertaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Rentang Nilai
         DB::table('tb_nilai_peserta')->insert([
            [
                'event_skema_id' => 1,
                'sub_skema_id' => 1,
                'peserta_id' => 1,
                'nilai' => 90,

                'created_by' => 0,
            ],
            [
                'event_skema_id' => 1,
                'sub_skema_id' => 2,
                'peserta_id' => 1,
                'nilai' => 80,

                'created_by' => 0,
            ],
            [
                'event_skema_id' => 1,
                'sub_skema_id' => 3,
                'peserta_id' => 1,
                'nilai' => 90,

                'created_by' => 0,
            ],
            [
                'event_skema_id' => 1,
                'sub_skema_id' => 1,
                'peserta_id' => 2,
                'nilai' => 78,

                'created_by' => 0,
            ],
            [
                'event_skema_id' => 1,
                'sub_skema_id' => 2,
                'peserta_id' => 2,
                'nilai' => 80,

                'created_by' => 0,
            ],
            [
                'event_skema_id' => 1,
                'sub_skema_id' => 3,
                'peserta_id' => 2,
                'nilai' => 82,

                'created_by' => 0,
            ],
            [
                'event_skema_id' => 1,
                'sub_skema_id' => 1,
                'peserta_id' => 3,
                'nilai' => 88,

                'created_by' => 0,
            ],
            [
                'event_skema_id' => 1,
                'sub_skema_id' => 2,
                'peserta_id' => 3,
                'nilai' => 83,

                'created_by' => 0,
            ],
            [
                'event_skema_id' => 1,
                'sub_skema_id' => 3,
                'peserta_id' => 3,
                'nilai' => 81,

                'created_by' => 0,
            ],
            [
                'event_skema_id' => 1,
                'sub_skema_id' => 1,
                'peserta_id' => 4,
                'nilai' => 82,

                'created_by' => 0,
            ],
            [
                'event_skema_id' => 1,
                'sub_skema_id' => 2,
                'peserta_id' => 4,
                'nilai' => 87,

                'created_by' => 0,
            ],
            [
                'event_skema_id' => 1,
                'sub_skema_id' => 3,
                'peserta_id' => 4,
                'nilai' => 85,

                'created_by' => 0,
            ],
            [
                'event_skema_id' => 2,
                'sub_skema_id' => 4,
                'peserta_id' => 5,
                'nilai' => 72,

                'created_by' => 0,
            ],
            [
                'event_skema_id' => 2,
                'sub_skema_id' => 4,
                'peserta_id' => 5,
                'nilai' => 74,

                'created_by' => 0,
            ]
        ]);
    }
}
