<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // === Admin === 
        User::updateOrCreate([
            'nama_lengkap' => 'Dedy Sutrisno',
            'email' => 'admin@gmail.com',
            'level' => 'Admin',
            'status'=> 'Aktif',
            'password' => 'admin123',

            'tempat_lahir'=> 'Rogojampi',
            'tgl_lahir'=> '2000-07-18',
            'jenis_kelamin'=> 'Laki-Laki',
            
            'nomor_induk'=> 2020101050,
            'alamat'=> 'Jalan yang licin',
            'alamat_kota'=> 'Banyuwangi Timur',
            'no_telp' => '082331867741',
        ]);

        // === Penguji ===
        User::updateOrCreate([
            'nama_lengkap' => 'Agus Hariyanto',
            'email' => 'penguji1@gmail.com',
            'level' => 'Penguji',
            'status'=> 'Aktif',
            'password' => 'penguji123',

            'instansi_id'=> 1,

            'tempat_lahir'=> 'Bondowoso',
            'tgl_lahir'=> '2024-02-16',
            'jenis_kelamin'=> 'Laki-Laki',

            'alamat' => 'Jalan yang terjal',
            'alamat_kota'=> 'Jember',
            'no_telp'=> '082331072471',

            'nomor_induk' => 2020101070,
            'jabatan_penguji'=> 'Penguji Tingkat 1',
            'type_penguji'=> 'Asesor Utama',
        ]);

        User::updateOrCreate([
            'nama_lengkap' => 'Denny Wijanarko',
            'email' => 'penguji2@gmail.com',
            'level' => 'Penguji',
            'status'=> 'Aktif',
            'password' => 'penguji123',

            'instansi_id'=> 1,

            'tempat_lahir'=> 'Lumajang',
            'tgl_lahir'=> '2024-01-17',
            'jenis_kelamin'=> 'Laki-Laki',

            'alamat' => 'Jalan yang terportal',
            'alamat_kota'=> 'Jember',
            'no_telp'=> '08233107971',

            'nomor_induk' => 2020101071,
            'jabatan_penguji'=> 'Penguji Tingkat 1',
            'type_penguji'=> 'Asesor Utama',
        ]);

        // === Peserta / Pengguna ===
        User::updateOrCreate([
            'nama_lengkap' => 'Septinus Yanes Samberbori',
            'email' => 'pengguna1@gmail.com',
            'level' => 'Pengguna',
            'status'=> 'Aktif',
            'password' => 'pengguna123',

            'instansi_id'=> 2,

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

        User::updateOrCreate([
            'nama_lengkap' => 'Yeferi Karoba',
            'email' => 'pengguna2@gmail.com',
            'level' => 'Pengguna',
            'status'=> 'Aktif',
            'password' => 'pengguna123',

            'instansi_id'=> 2,

            'tempat_lahir'=> 'Kalolo',
            'tgl_lahir'=> '2024-03-06',
            'jenis_kelamin'=> 'Laki-Laki',
            'nomor_induk'=> 2020101091,
            'alamat'=> 'Jalan yang berat',
            'alamat_kota'=> 'Papua Timur',
            'no_telp' => '082331867631',

            'nama_sekolah' => 'Politeknik Negeri Jember',
            'Jurusan'=> 'Teknik Komputer',
            'Jenjang'=> 'Diploma 3',
            'tahun_lulus'=> '2023',

            'nama_perusahaan'=> 'Sumber Kencono',
            'alamat_perusahaan'=> 'Jalan yang belok',
            'alamat_kota_perusahaan' => 'Jember',
            'jabatan_pekerjaan' => 'Sysadmin',
            'no_telp_perusahaan' => '12300214'
        ]);

        User::updateOrCreate([
            'nama_lengkap' => 'Slamet Kopleng',
            'email' => 'pengguna3@gmail.com',
            'level' => 'Pengguna',
            'status'=> 'Aktif',
            'password' => 'pengguna123',

            'instansi_id'=> 2,

            'tempat_lahir'=> 'Jember',
            'tgl_lahir'=> '2024-03-06',
            'jenis_kelamin'=> 'Laki-Laki',
            'nomor_induk'=> 2020101091,
            'alamat'=> 'Jalan yang berat',
            'alamat_kota'=> 'Papua Timur',
            'no_telp' => '082331867631',

            'nama_sekolah' => 'Politeknik Negeri Jember',
            'Jurusan'=> 'Teknik Komputer',
            'Jenjang'=> 'Diploma 3',
            'tahun_lulus'=> '2023',

            'nama_perusahaan'=> 'Sumber Kencono',
            'alamat_perusahaan'=> 'Jalan yang belok',
            'alamat_kota_perusahaan' => 'Jember',
            'jabatan_pekerjaan' => 'Sysadmin',
            'no_telp_perusahaan' => '12300214'
        ]);

        User::updateOrCreate([
            'nama_lengkap' => 'Bodrex',
            'email' => 'pengguna4@gmail.com',
            'level' => 'Pengguna',
            'status'=> 'Aktif',
            'password' => 'pengguna123',

            'instansi_id'=> 2,

            'tempat_lahir'=> 'Kalolo',
            'tgl_lahir'=> '2024-03-06',
            'jenis_kelamin'=> 'Laki-Laki',
            'nomor_induk'=> 2020101091,
            'alamat'=> 'Jalan yang berat',
            'alamat_kota'=> 'Papua Timur',
            'no_telp' => '082331867631',

            'nama_sekolah' => 'Politeknik Negeri Jember',
            'Jurusan'=> 'Teknik Komputer',
            'Jenjang'=> 'Diploma 3',
            'tahun_lulus'=> '2023',

            'nama_perusahaan'=> 'Sumber Kencono',
            'alamat_perusahaan'=> 'Jalan yang belok',
            'alamat_kota_perusahaan' => 'Jember',
            'jabatan_pekerjaan' => 'Sysadmin',
            'no_telp_perusahaan' => '12300214'
        ]);
    }
}
