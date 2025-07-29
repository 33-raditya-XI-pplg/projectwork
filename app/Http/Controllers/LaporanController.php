<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    /**
     * Display the laporan perkembangan for a specific event skema.
     *
     * @param Request $request
     * @param int $idEventSkema
     * @return \Illuminate\View\View|\Illuminate\Http\Response
     */
    public function index(Request $request, $idEventSkema)
{
    $Title = 'Laporan perkembangan';
    $user = Auth::user();

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
    ->get();

// Ambil item pertama dari collection
$dataItem = $data->first();

if (!$dataItem) {
    return abort(404, 'Data tidak ditemukan.');
}

$laporanList = DB::table('tb_laporan_perkembangan')
    ->where('event_skema_id', $dataItem->id_event_skema)
    ->where('peserta_id', $dataItem->id_peserta)
    ->get();

$daftarPerkembangan = [];

foreach ($laporanList as $laporan) {
    $kemampuanDasar = DB::table('tb_kemampuan_dasar')
        ->where('laporan_perkembangan_id', $laporan->id_laporan_perkembangan)
        ->get();

    $daftarPerkembangan[] = [
        'laporan' => $laporan,
        'kemampuan_dasar' => $kemampuanDasar,
    ];
}

$detail = [
    'id_event_skema' => $dataItem->id_event_skema,
    'nama_skema' => $dataItem->nama_skema,
    'nama_event' => $dataItem->nama_event,
    'nama_lengkap' => $dataItem->nama_lengkap,
    'perkembangan' => $daftarPerkembangan, // array dari banyak laporan
];

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
