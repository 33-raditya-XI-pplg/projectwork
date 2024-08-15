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
        // === CATATAN ===
        // Data hasil Seder yang memiliki foto dari folder (/Dummy) -- TIDAK DAPAT DI EDIT

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
            PesertaSeeder::class,
            MengujiSeeder::class,
            EventSkemaRentangNilaiSeeder::class,
            PenandatanganSeeder::class,
            NilaiPesertaSeeder::class,
            PageTableSeeder::class,
            KategoriSeeder::class,
              // BlogSeeder::class,
        ]);
    }
}
