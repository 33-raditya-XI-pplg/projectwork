<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MengujiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tb_menguji')->insert([
            [
                'user_id' => 2,
                'event_skema_id' => 1,

                'created_by' => 0,
            ],
            [
                'user_id' => 3,
                'event_skema_id' => 1,

                'created_by' => 0,
            ],
            [
                'user_id' => 4,
                'event_skema_id' => 1,

                'created_by' => 0,
            ]
        ]);
    }
}
