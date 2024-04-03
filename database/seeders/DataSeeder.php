<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

use App\Models\Rentang_Nilai as Rentang;
use App\Models\Jenis_Event;
use App\Models\Instansi;
use App\Models\Tempat;
use App\Models\User;
use App\Models\Ttd;

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

        // foreach (range(1, 2) as $index) {
        //     Instansi::updateOrCreate([
        //         'nama_instansi' => $faker->company,
        //         'nomor_instansi' => $faker->randomNumber(8),
        //         'nama_kepala_instansi' => $faker->name,
        //         'jabatan_kepala' => $faker->jobTitle,
        //         'path_logo' => $faker->imageUrl(),
        //         'status' => 'Aktif',
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

        // for($i=0; $i <10; $i++) {
        //     Rentang::updateOrCreate([
        //         'nama_konversi_nilai' => $faker->name,
        //         'inisial_rentang_nilai' => $faker->suffix(),
        //         'rentang_atas' => $faker->randomDigit(),
        //         'rentang_bawah' => $faker->randomDigit(),
        //     ]);
        // }
        
        // // Instansi
        // DB::table('tb_instansi')->insert([
        //     [
        //         'nama_instansi' => 'Politeknik Negeri Jember',
        //         'nomor_instansi' => 430,
        //         'nama_kepala_instansi' => 'Purwanto',
        //         'jabatan_kepala' => 'Pembina Tingkat 1',
        //         'path_logo' => 'assets\img\icon.png',
        //         'status' => 'Aktif',
        //         'alamat' => 'Jalan yang termasuk benar',
        //         'alamat_kota' => 'Jember',
        //         'email' => 'polije@gmail.com',
        //         'no_telp' => '0334-18045'
        //     ],
        //     [
        //         'nama_instansi' => 'Politeknik Negeri Lhoksumawe',
        //         'nomor_instansi' => 431,
        //         'nama_kepala_instansi' => 'Sunarwito',
        //         'jabatan_kepala' => 'Direktur',
        //         'path_logo' => 'assets\img\icon.png',
        //         'status' => 'Aktif',
        //         'alamat' => 'Jalan yang termasuk salah',
        //         'alamat_kota' => 'Lhoksumawe',
        //         'email' => 'sumawe@gmail.com',
        //         'no_telp' => '0334-18046'
        //     ],
        // ]);

        // // Tempat
        // DB::table('tb_tempat')->insert([
        //     [
        //         'nama_tempat' => 'Gedung Sertifikasi LSP Polije',
        //         'no_telp' => '0334-18055',
        //         'alamat' => 'Jalan yang keras',
        //         'alamat_kota' => 'Jember',
        //         'link_maps' => 'https://www.google.com/maps/place//@-8.1939106,113.679965,15z/data=!3m1!4b1?entry=ttu',
        //     ],
        //     [
        //         'nama_tempat' => 'Gedung Serbaguna Lhoksumawe',
        //         'no_telp' => '0334-18056',
        //         'alamat' => 'Jalan yang berbatu',
        //         'alamat_kota' => 'Lhoksumawe',
        //         'link_maps' => 'https://www.google.com/maps/place//@-8.1946681,113.6802083,14.5z?entry=ttu',
        //     ]
        // ]);

        // // Rentang Nilai
        // DB::table('tb_rentang_nilai')->insert([
        //     [
        //         'nama_konversi_nilai' => 'konversi_abcd',
        //         'inisial_rentang_nilai' => 'A',
        //         'rentang_atas' => 100,
        //         'rentang_bawah' => 94,
        //     ],
        //     [
        //         'nama_konversi_nilai' => 'konversi_abcd',
        //         'inisial_rentang_nilai' => 'B',
        //         'rentang_atas' => 93,
        //         'rentang_bawah' => 84,
        //     ],
        //     [
        //         'nama_konversi_nilai' => 'konversi_abcd',
        //         'inisial_rentang_nilai' => 'C',
        //         'rentang_atas' => 83,
        //         'rentang_bawah' => 74,
        //     ],
        //     [
        //         'nama_konversi_nilai' => 'konversi_abcd',
        //         'inisial_rentang_nilai' => 'D',
        //         'rentang_atas' => 73,
        //         'rentang_bawah' => 0,
        //     ],
        //     [
        //         'nama_konversi_nilai' => 'konversi_kompeten',
        //         'inisial_rentang_nilai' => 'Sangat Kompeten',
        //         'rentang_atas' => 100,
        //         'rentang_bawah' => 90,
        //     ],
        //     [
        //         'nama_konversi_nilai' => 'konversi_kompeten',
        //         'inisial_rentang_nilai' => 'Cukup Kompeten',
        //         'rentang_atas' => 89,
        //         'rentang_bawah' => 80,
        //     ],
        //     [
        //         'nama_konversi_nilai' => 'konversi_kompeten',
        //         'inisial_rentang_nilai' => 'Kurang Kompeten',
        //         'rentang_atas' => 79,
        //         'rentang_bawah' => 60,
        //     ],
        //     [
        //         'nama_konversi_nilai' => 'konversi_kompeten',
        //         'inisial_rentang_nilai' => 'Tidak Kompeten',
        //         'rentang_atas' => 59,
        //         'rentang_bawah' => 0,
        //     ],
        // ]);

        // // === Admin === 
        // User::updateOrCreate([
        //     'nama_lengkap' => 'Dedy Sutrisno',
        //     'email' => 'admin@gmail.com',
        //     'level' => 'Admin',
        //     'status'=> 'Aktif',
        //     'password' => 'admin123',

        //     'tempat_lahir'=> 'Rogojampi',
        //     'tgl_lahir'=> '2000-07-18',
        //     'jenis_kelamin'=> 'Laki-Laki',
            
        //     'nomor_induk'=> 2020101050,
        //     'alamat'=> 'Jalan yang licin',
        //     'alamat_kota'=> 'Banyuwangi Timur',
        //     'no_telp' => '082331867741',
        // ]);

        // // === Penguji ===
        // User::updateOrCreate([
        //     'nama_lengkap' => 'Agus Hariyanto',
        //     'email' => 'penguji1@gmail.com',
        //     'level' => 'Penguji',
        //     'status'=> 'Aktif',
        //     'password' => 'penguji123',

        //     'instansi_id'=> 1,

        //     'alamat' => 'Jalan yang terjal',
        //     'alamat_kota'=> 'Jember',
        //     'no_telp'=> '082331072471',

        //     'nomor_induk' => 2020101070,
        //     'jabatan_penguji'=> 'Penguji Tingkat 1',
        //     'jabatan_penguji'=> 'Asesor Utama',
        // ]);

        // User::updateOrCreate([
        //     'nama_lengkap' => 'Denny Wijanarko',
        //     'email' => 'penguji2@gmail.com',
        //     'level' => 'Penguji',
        //     'status'=> 'Aktif',
        //     'password' => 'penguji123',

        //     'instansi_id'=> 1,

        //     'alamat' => 'Jalan yang terportal',
        //     'alamat_kota'=> 'Jember',
        //     'no_telp'=> '08233107971',

        //     'nomor_induk' => 2020101071,
        //     'jabatan_penguji'=> 'Penguji Tingkat 1',
        //     'jabatan_penguji'=> 'Asesor Utama',
        // ]);

        // // === Peserta / Pengguna ===
        // User::updateOrCreate([
        //     'nama_lengkap' => 'Septinus Yanes Samberbori',
        //     'email' => 'pengguna1@gmail.com',
        //     'level' => 'Pengguna',
        //     'status'=> 'Aktif',
        //     'password' => 'pengguna123',

        //     'instansi_id'=> 2,

        //     'tempat_lahir'=> 'Wamena',
        //     'tgl_lahir'=> '2024-03-06',
        //     'jenis_kelamin'=> 'Laki-Laki',
        //     'nomor_induk'=> 2020101090,
        //     'alamat'=> 'Jalan yang benar',
        //     'alamat_kota'=> 'Papua Barat',
        //     'no_telp' => '082331867134',

        //     'nama_sekolah' => 'Politeknik Negeri Jember',
        //     'Jurusan'=> 'Teknik Komputer',
        //     'Jenjang'=> 'Diploma 3',
        //     'tahun_lulus'=> '2023',

        //     'nama_perusahaan'=> 'Sumber Makmur',
        //     'alamat_perusahaan'=> 'Jalan yang hancur',
        //     'alamat_kota_perusahaan' => 'Jember',
        //     'jabatan_pekerjaan' => 'Teknisi',
        //     'no_telp_perusahaan' => '12300123'
        // ]);

        // User::updateOrCreate([
        //     'nama_lengkap' => 'Yeferi Karoba',
        //     'email' => 'pengguna2@gmail.com',
        //     'level' => 'Pengguna',
        //     'status'=> 'Aktif',
        //     'password' => 'pengguna123',

        //     'instansi_id'=> 2,

        //     'tempat_lahir'=> 'Kalolo',
        //     'tgl_lahir'=> '2024-03-06',
        //     'jenis_kelamin'=> 'Laki-Laki',
        //     'nomor_induk'=> 2020101091,
        //     'alamat'=> 'Jalan yang berat',
        //     'alamat_kota'=> 'Papua Timur',
        //     'no_telp' => '082331867631',

        //     'nama_sekolah' => 'Politeknik Negeri Jember',
        //     'Jurusan'=> 'Teknik Komputer',
        //     'Jenjang'=> 'Diploma 3',
        //     'tahun_lulus'=> '2023',

        //     'nama_perusahaan'=> 'Sumber Kencono',
        //     'alamat_perusahaan'=> 'Jalan yang belok',
        //     'alamat_kota_perusahaan' => 'Jember',
        //     'jabatan_pekerjaan' => 'Sysadmin',
        //     'no_telp_perusahaan' => '12300214'
        // ]);

        // // TTD
        // DB::table('tb_ttd')->insert([
        //     [
        //         'instansi_id' => 1,
        //         'nama_ttd' => 'Agus Hariyanto',
        //         'jabatan' => 'Penguji Tingkat 1',
        //         'nomor_induk' => 2020101070,
        //         'path_ttd' => 'assets\img\dummy\ttd\ttd_agus.png',
        //         'status' => 'Aktif'
        //     ],
        //     [
        //         'instansi_id' => 1,
        //         'nama_ttd' => 'Denny Wijanarko',
        //         'jabatan' => 'Penguji Tingkat 1',
        //         'nomor_induk' => 2020101071,
        //         'path_ttd' => 'assets\img\dummy\ttd\ttd_denny.png',
        //         'status' => 'Aktif'
        //     ]
        // ]);

        // // Jenis Event
        // DB::table('tb_jenis_event')->insert([
        //     [
        //         'nama_jenis_event' => 'Sertifikasi',
        //         'has_lampiran' => 1,
        //         'deskripsi' => 'Acara sertifikasi yang diadakan oleh lembaga sertifikasi',
        //         'status' => 'Aktif'
        //     ],
        //     [
        //         'nama_jenis_event' => 'Seminar',
        //         'has_lampiran' => 0,
        //         'deskripsi' => 'Acara multitema yang diadakan oleh suatu instansi',
        //         'status' => 'Aktif'
        //     ]
        // ]);

        // // Background
        // DB::table('tb_background')->insert([
        //     [
        //         'nama_bg' => 'bg_sertifikasi',
        //         'orientasi_bg' => 'landscape',
        //         'path_bg' => 'assets\img\dummy\bg\template_sertifikasi.png',
        //         'rincian_bg' => 'Background khusus Sertifikasi'
        //     ],
        //     [
        //         'nama_bg' => 'bg_seminar',
        //         'orientasi_bg' => 'landscape',
        //         'path_bg' => 'assets\img\dummy\bg\template_seminar.png',
        //         'rincian_bg' => 'Background khusus Seminar'
        //     ],
        //     [
        //         'nama_bg' => 'bg_piagam_1',
        //         'orientasi_bg' => 'potrait',
        //         'path_bg' => 'assets\img\dummy\bg\template_piagam_1.png',
        //         'rincian_bg' => 'Background khusus Piagam-1'
        //     ],
        //     [
        //         'nama_bg' => 'bg_piagam_2',
        //         'orientasi_bg' => 'potrait',
        //         'path_bg' => 'assets\img\dummy\bg\template_piagam_2.png',
        //         'rincian_bg' => 'Background khusus Piagam-2'
        //     ]
        // ]);

        // // Event
        // DB::table('tb_event')->insert([
        //     [
        //         'instansi_id' => 1,
        //         'tempat_id' => 1,
        //         'jenis_event_id' => 1,
        //         'nama_event' => 'Uji Komputer',
        //         'tgl_mulai' => '2024-04-3',
        //         'tgl_berakhir' => '2024-04-30',
        //         'biaya_regis' => 500000,
        //         'path_banner' => 'assets\img\dummy\banner_event\banner_1.png',
        //         'deskripsi' => 'Uji komputer diadakan oleh Badan LSP Polije',
        //         'status' => 'Aktif',
        //         'visibilitas' => 'publik'
        //     ],
        //     [
        //         'instansi_id' => 1,
        //         'tempat_id' => 1,
        //         'jenis_event_id' => 1,
        //         'nama_event' => 'Uji Kompetensi',
        //         'tgl_mulai' => '2024-04-3',
        //         'tgl_berakhir' => '2024-04-30',
        //         'biaya_regis' => 300000,
        //         'path_banner' => 'assets\img\dummy\banner_event\banner_2.png',
        //         'deskripsi' => 'Uji kompetensi profesi diadakan oleh Badan LSP Polije',
        //         'status' => 'Aktif',
        //         'visibilitas' => 'publik'
        //     ]
        // ]);

        // // Skema
        // DB::table('tb_skema')->insert([
        //     [
        //         'nama_skema' => 'Junior Web Dev',
        //         'path_icon' => 'assets\img\dummy\icon_skema\icon_skema_1.png',
        //         'has_sub_skema' => 1,
        //         'status' => 'Aktif'
        //     ],
        //     [
        //         'nama_skema' => 'Junior Mobile Dev',
        //         'path_icon' => 'assets\img\dummy\icon_skema\icon_skema_1.png',
        //         'has_sub_skema' => 1,
        //         'status' => 'Aktif'
        //     ],
        //     [
        //         'nama_skema' => 'Microsoft Windows',
        //         'path_icon' => 'assets\img\dummy\icon_skema\icon_skema_2.png',
        //         'has_sub_skema' => 1,
        //         'status' => 'Aktif'
        //     ],
        //     [
        //         'nama_skema' => 'Microsoft Office',
        //         'path_icon' => 'assets\img\dummy\icon_skema\icon_skema_2.png',
        //         'has_sub_skema' => 1,
        //         'status' => 'Aktif'
        //     ]
        // ]); 

        // DB::table('tb_sub_skema')->insert([
        //     [
        //         'skema_id' => 1,
        //         'judul_sub' => 'Memahami framework laravel'
        //     ],
        //     [
        //         'skema_id' => 1,
        //         'judul_sub' => 'Mampu membuat CRUD menggunakan laravel'
        //     ],
        //     [
        //         'skema_id' => 2,
        //         'judul_sub' => 'Memahami framework flutter'
        //     ],
        //     [
        //         'skema_id' => 2,
        //         'judul_sub' => 'Mampu membuat CRUD menggunakan flutter'
        //     ],
        //     [
        //         'skema_id' => 3,
        //         'judul_sub' => 'Memahami sistem navigasi windows'
        //     ],
        //     [
        //         'skema_id' => 3,
        //         'judul_sub' => 'Mampu mengoperasikan windows'
        //     ],
        //     [
        //         'skema_id' => 4,
        //         'judul_sub' => 'Memahami microsoft word'
        //     ],
        //     [
        //         'skema_id' => 4,
        //         'judul_sub' => 'Mampu membuat artikel pada microsoft word'
        //     ]
        // ]);

    }
}
