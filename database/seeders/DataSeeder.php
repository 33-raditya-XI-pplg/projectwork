<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use Carbon\Carbon;

use App\Models\Instansi;
use App\Models\Tempat;
use App\Models\User;
use App\Models\Rentang_Nilai as Rentang;

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

        foreach (range(1, 2) as $index) {
            Instansi::updateOrCreate([
                'nama_instansi' => $faker->company,
                'nomor_instansi' => $faker->randomNumber(8),
                'nama_kepala_instansi' => $faker->name,
                'jabatan_kepala' => $faker->jobTitle,
                'path_logo' => $faker->imageUrl(),
                'status' => 'Aktif',
                'alamat' => $faker->address,
                'alamat_kota' => $faker->city,
                'email' => $faker->companyEmail,
                'no_telp' => $faker->phoneNumber,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            Tempat::create([
                'nama_tempat' => $faker->company,
                'no_telp' => $faker->phoneNumber,
                'alamat' => $faker->address,
                'alamat_kota' => $faker->city,
                'link_maps' => $faker->url,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        for($i=0; $i <10; $i++) {
            Rentang::updateOrCreate([
                'nama_konversi_nilai' => $faker->name,
                'inisial_rentang_nilai' => $faker->suffix(),
                'rentang_atas' => $faker->randomDigit(),
                'rentang_bawah' => $faker->randomDigit(),
            ]);
        }


        User::updateOrCreate([
            'nama_lengkap' => 'Dedy Sutrisno',
            'email' => 'admin@gmail.com',
            'level' => 'Admin',
            'status'=> 'Aktif',
            'password' => 'admin123'
        ]);

        User::updateOrCreate([
            'nama_lengkap' => 'Agus Hariyanto',
            'email' => 'penguji@gmail.com',
            'level' => 'Penguji',
            'status'=> 'Aktif',
            'password' => 'penguji123',

            'instansi_id'=> 1,
            'alamat' => 'Jalan yang terjal',
            'alamat_kota'=> 'Jember',
            'no_telp'=> '082331072471',

            'nomor_induk' => 2020101070,
            'jabatan_penguji'=> 'Penguji Tingkat 1',
        ]);

        User::updateOrCreate([
            'nama_lengkap' => 'Septinus Yanes Samberbori',
            'email' => 'pengguna@gmail.com',
            'level' => 'Pengguna',
            'status'=> 'Aktif',
            'password' => 'pengguna123',

            'tempat_lahir'=> 'Wamena',
            'tgl_lahir'=> '2024-03-06',
            'jenis_kelamin'=> 'Laki-Laki',
            'nomor_induk'=> 2020101090,
            'alamat'=> 'Jalan yang benar',
            'alamat_kota'=> 'Papua Barat',

            'no_telp' => '082331867134',
            'nama_sekolah' => 'Politeknik Negeri Jember',
            'Jurusan'=> 'Teknik Komputer',
            'Jenjang'=> 'Diploma 3',
            'tahun_lulus'=> '2023',

            'nama_perusahaan'=> 'Sumber Makmur',
            'alamat_perusahaan'=> 'Jalan yang hancur',
            'alamat_kota_perusahaan' => 'Jember',
            'jabatan_pekerjaan' => 'Teknisi',
            'no_telp_perusahaan' => '12300123'
        ]);
    }
}
