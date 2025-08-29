<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LaporanPerkembanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tb_laporan_perkembangan')->insert([
            [
                'event_skema_id' => 1,
                'peserta_id' => 2,
                'tanggal_penilaian' => Carbon::now(),
                'catatan' => 'Laporan perkembangan peserta 1',
                'pengalaman_anak' => 'Peserta menunjukkan kemajuan yang signifikan dalam keterampilan yang telah diajarkan.',
                'peralatan_penunjang' => 'Peralatan A, Peralatan B',
                'saran' => 'Perlu meningkatkan keterampilan di bidang X',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

        ]);
    }
}
