<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PesertaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tb_peserta')->insert([
            [
                'user_id' => 6,
                'event_skema_id' => 1,

                'created_by' => 0,
            ],
            [
                'user_id' => 7,
                'event_skema_id' => 1,

                'created_by' => 0,
            ],
            [
                'user_id' => 8,
                'event_skema_id' => 1,

                'created_by' => 0,
            ],
            [
                'user_id' => 9,
                'event_skema_id' => 1,

                'created_by' => 0,
            ],
            [
                'user_id' => 6,
                'event_skema_id' => 2,

                'created_by' => 0,
            ],
            [
                'user_id' => 7,
                'event_skema_id' => 2,

                'created_by' => 0,
            ],
            [
                'user_id' => 6,
                'event_skema_id' => 3,

                'created_by' => 0,
            ]
        ]);
    }
}
