<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            TempatSeeder::class,
            InstansiSeeder::class,
            RentangNilaiSeeder::class,
            SkemaSeeder::class,
            BackgroundSeeder::class,
            JenisEventSeeder::class,

            UserSeeder::class,
            TtdSeeder::class,
            EventSeeder::class,
            EventSkemaSeeder::class,
            DaftarPesertaSeeder::class
        ]);
    }
}
