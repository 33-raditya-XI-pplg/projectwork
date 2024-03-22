<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use Carbon\Carbon;

use App\Models\Instansi;
use App\Models\Tempat;
use App\Models\User;

class DataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        User::create([
            'nama_lengkap' => 'Mas Admin',
            'email'=> 'admin@gmail.com',
            'password'=> Hash::make('admin123'),
        ]);
        User::updateOrCreate([
            'nama_lengkap' => 'Dedy Sutrisno',
            'email' => 'dedihar11@gmail.com',
            'password' => 'admin123'
        ]);

        foreach (range(1, 20) as $index) {
            Instansi::create([
                'nama_instansi' => $faker->company,
                'nomor_instansi' => $faker->randomNumber(8),
                'nama_kepala_instansi' => $faker->name,
                'jabatan_kepala' => $faker->jobTitle,
                'path_logo' => $faker->imageUrl(),
                'status' => $faker->randomElement(['Aktif', 'Nonaktif']),
                'alamat' => $faker->address,
                'alamat_kota' => $faker->city,
                'email' => $faker->companyEmail,
                'no_telp' => $faker->phoneNumber,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        // foreach (range(1, 20) as $index) {
        //     Instansi::create([
        //         'nama_instansi' => $faker->company,
        //         'nomor_instansi' => $faker->randomNumber(8),
        //         'nama_kepala_instansi' => $faker->name,
        //         'jabatan_kepala' => $faker->jobTitle,
        //         'path_logo' => $faker->imageUrl(),
        //         'status' => $faker->randomElement(['Aktif', 'Nonaktif']),
        //         'alamat' => $faker->address,
        //         'alamat_kota' => $faker->city,
        //         'email' => $faker->companyEmail,
        //         'no_telp' => $faker->phoneNumber,
        //         'created_by' => 1,
        //         'updated_by' => 1,
        //         'created_at' => Carbon::now(),
        //         'updated_at' => Carbon::now(),
        //     ]);

        //     Tempat::create([
        //         'nama_tempat' => $faker->company,
        //         'no_telp' => $faker->phoneNumber,
        //         'alamat' => $faker->address,
        //         'alamat_kota' => $faker->city,
        //         'link_maps' => $faker->url,
        //         'created_by' => 1,
        //         'updated_by' => 1,
        //         'created_at' => Carbon::now(),
        //         'updated_at' => Carbon::now(),
        //     ]);
        // }

    }
}
