<?php

namespace App\Http\Controllers\User;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function user_index()
    {
        $banyak_pengguna = DB::table('tb_user')
            ->where('level', 'pengguna')
            ->count();

        $banyak_penguji = DB::table('tb_user')
            ->where('level', 'penguji')
            ->count();

        $banyak_skema = DB::table('tb_skema')->count();
        $banyak_event = DB::table('tb_event')->count();

        $data_event = Event::where('status', 'Berlangsung')->get();


        $user = Auth::user();
        $isProfileComplete = !empty($user->nama_lengkap) && !empty($user->alamat) && !empty($user->jenis_kelamin)
            && !empty($user->tgl_lahir) && !empty($user->tempat_lahir) && !empty($user->nomor_induk) && !empty($user->nomor_induk)
            && !empty($user->alamat_kota) && !empty($user->nama_sekolah) && !empty($user->jurusan) && !empty($user->jenjang)
            && !empty($user->tahun_lulus) && !empty($user->nama_perusahaan) && !empty($user->alamat_perusahaan)
            && !empty($user->alamat_kota_perusahaan) && !empty($user->jabatan_pekerjaan) && !empty($user->no_telp_perusahaan);

        return view('user.dashboard', compact(
            'banyak_pengguna',
            'banyak_penguji',
            'banyak_skema',
            'banyak_event',
            'data_event',
            'isProfileComplete'
        ));
    }

    public function admin_index()
    {
        $banyak_pengguna = DB::table('tb_user')
            ->where('level', 'pengguna')
            ->count();

        $banyak_penguji = DB::table('tb_user')
            ->where('level', 'penguji')
            ->count();

        $banyak_skema = DB::table('tb_skema')->count();
        $banyak_event = DB::table('tb_event')->count();

        $data_event = Event::where('status', 'Berlangsung')->get();

        $usersToVerify = DB::table('tb_user')
            ->where('level', 'pengguna')
            ->whereNotnull('nama_lengkap')
            ->whereNotNull('alamat')
            ->whereNotNull('jenis_kelamin')
            ->whereNotNull('tgl_lahir')
            ->whereNotNull('tempat_lahir')
            ->whereNotNull('nomor_induk')
            ->whereNotNull('alamat_kota')
            ->whereNotNull('nama_sekolah')
            ->whereNotNull('jurusan')
            ->whereNotNull('jenjang')
            ->whereNotNull('tahun_lulus')
            ->where('status', 'Belum Verified')
            ->get();

        return view('admin.dashboard', compact(
            'banyak_pengguna',
            'banyak_penguji',
            'banyak_skema',
            'banyak_event',
            'data_event',
            'usersToVerify',
        ));
    }
}
