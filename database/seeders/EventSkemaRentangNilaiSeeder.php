<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EventSkemaRentangNilaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tb_event_skema_rentang_nilai')->insert([
            [
                'event_skema_id' => 1,
                'rentang_nilai_id' => 1,

                'created_by' => 0,
            ],
            [
                'event_skema_id' => 1,
                'rentang_nilai_id' => 2,

                'created_by' => 0,
            ],
            [
                'event_skema_id' => 1,
                'rentang_nilai_id' => 3,

                'created_by' => 0,
            ],
            [
                'event_skema_id' => 1,
                'rentang_nilai_id' => 4,

                'created_by' => 0,
            ],
            [
                'event_skema_id' => 2,
                'rentang_nilai_id' => 5,

                'created_by' => 0,
            ],
            [
                'event_skema_id' => 2,
                'rentang_nilai_id' => 6,

                'created_by' => 0,
            ],
            [
                'event_skema_id' => 2,
                'rentang_nilai_id' => 7,

                'created_by' => 0,
            ],
            [
                'event_skema_id' => 2,
                'rentang_nilai_id' => 8,

                'created_by' => 0,
            ],
        ]);
    }
}
