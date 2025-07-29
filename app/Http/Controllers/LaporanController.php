<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index(Request $request, $idEventSkema)
{
    $Title = 'Laporan perkembangan';
    $user = Auth::user();

    // Ambil data utama peserta dan event
    $data = DB::table('tb_event_skema')
        ->join('tb_event', 'tb_event_skema.event_id', '=', 'tb_event.id_event')
        ->join('tb_skema', 'tb_skema.id_skema', '=', 'tb_event_skema.skema_id')
        ->join('tb_peserta', 'tb_event_skema.id_event_skema', '=', 'tb_peserta.event_skema_id')
        ->join('tb_user', 'tb_peserta.user_id', '=', 'tb_user.id_user')
        ->select(
            'tb_event_skema.id_event_skema',
            'tb_skema.nama_skema',
            'tb_event.nama_event',
            'tb_user.nama_lengkap',
            'tb_peserta.id_peserta'
        )
        ->where('tb_user.id_user', $user->id_user)
        ->where('tb_event_skema.id_event_skema', $idEventSkema)
        ->first();

    if (!$data) {
        return abort(404, 'Data tidak ditemukan.');
    }

    // Ambil laporan perkembangan (satu saja)
    $laporan = DB::table('tb_laporan_perkembangan')
        ->where('event_skema_id', $data->id_event_skema)
        ->where('peserta_id', $data->id_peserta)
        ->first();

    // Ambil kemampuan dasar (jika ada)
    $kemampuanDasar = [];

    if ($laporan) {
        $kemampuanDasar = DB::table('tb_kemampuan_dasar')
            ->where('laporan_perkembangan_id', $laporan->id_laporan_perkembangan) // pastikan nama kolom foreign key benar
            ->get();
    }

    // Gabungkan semua ke $detail
    $detail = [
        'id_event_skema' => $data->id_event_skema,
        'nama_skema' => $data->nama_skema,
        'nama_event' => $data->nama_event,
        'nama_lengkap' => $data->nama_lengkap,
        'perkembangan' => $laporan,
        'kemampuan_dasar' => $kemampuanDasar,
    ];

    // dd($detail['perkembangan']);
    return view('user.event.laporan.laporan-perkembangan', compact('Title', 'detail', 'user'));
}


    public function fetchPesertaData()
    {
        $id = Auth::user();

        $data_peserta = DB::table('tb_peserta')
            ->join('tb_user', 'tb_peserta.user_id', '=', 'tb_user.id_user')
            ->join('tb_event_skema', 'tb_peserta.event_skema_id', '=', 'tb_event_skema.id_event_skema')
            ->leftJoin('tb_laporan_perkembangan', 'tb_peserta.id_peserta', '=', 'tb_laporan_perkembangan.peserta_id')
            ->select(
                'tb_peserta.id_peserta',
                'tb_user.nama_lengkap',
                'tb_event_skema.id_event_skema',
                'tb_laporan_perkembangan.catatan',
                'tb_laporan_perkembangan.tanggal_penilaian',
            )
            ->get();

        return response()->json([
            'data_peserta' => $id,
        ]);
    }
}
