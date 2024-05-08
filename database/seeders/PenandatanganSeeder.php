<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PenandatanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tb_penandatangan')->insert([
            [
                'event_skema_id' => 1,
                'ttd_id' => 1,

                'created_by' => 0,
            ],
            [
                'event_skema_id' => 1,
                'ttd_id' => 2,

                'created_by' => 0,
            ],
            [
                'event_skema_id' => 2,
                'ttd_id' => 1,

                'created_by' => 0,
            ],
            [
                'event_skema_id' => 2,
                'ttd_id' => 2,

                'created_by' => 0,
            ]
        ]);
    }
}
