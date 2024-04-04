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
        $this->call(TempatSeeder::class);
        $this->call(InstansiSeeder::class);
        $this->call(RentangNilaiSeeder::class);
        $this->call(SkemaSeeder::class);
        $this->call(BackgroundSeeder::class);
        $this->call(JenisEventSeeder::class);

        $this->call(UserSeeder::class);
        $this->call(TtdSeeder::class);
        $this->call(EventSeeder::class);
        $this->call(EventSkemaSeeder::class);
        $this->call(DaftarPesertaSeeder::class);

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
