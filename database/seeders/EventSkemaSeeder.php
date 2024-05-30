<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventSkemaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tb_event_skema')->insert([
            [
                'event_id' => 1,
                'skema_id' => 1,
                'background_id' => 3,

                'created_by' => 0,
            ],
            [
                'event_id' => 1,
                'skema_id' => 2,
                'background_id' => 1,

                'created_by' => 0,
            ],
            [
                'event_id' => 2,
                'skema_id' => 3,
                'background_id' => 2,

                'created_by' => 0,
            ],
            [
                'event_id' => 2,
                'skema_id' => 4,
                'background_id' => 2,

                'created_by' => 0,
            ],
            [
                'event_id' => 3,
                'skema_id' => 5,
                'background_id' => 2,

                'created_by' => 0,
            ],
            [
                'event_id' => 3,
                'skema_id' => 6,
                'background_id' => 2,

                'created_by' => 0,
            ]
        ]);
    }
}
