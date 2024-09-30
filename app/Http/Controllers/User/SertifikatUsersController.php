<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use Barryvdh\DomPDF\Facade\Pdf;

class SertifikatUsersController extends Controller
{
    public function index()
    {
        $data_sertifikat_peserta = DB::table('tb_peserta')
            ->join('tb_event_skema', 'tb_peserta.event_skema_id', '=', 'tb_event_skema.id_event_skema')
            ->join('tb_event', 'tb_event_skema.event_id', '=', 'tb_event.id_event')
            ->join('tb_skema', 'tb_event_skema.skema_id', '=', 'tb_skema.id_skema')
            ->select(
                'tb_event.id_event',
                'tb_event.nama_event',
                'tb_event.status',
                'tb_event.tgl_mulai',
                'tb_event.tgl_berakhir'
            )
            ->where('tb_peserta.user_id', Auth::user()->id_user)
            ->distinct()
            ->get();
        $Title = 'Sertifikat';
        return view('user.sertifikat.index', compact('data_sertifikat_peserta', 'Title'));
    }
    public function cetak1() // ==== Easter Egg ====
    {
        return view('user.sertifikat.cetak_sertifikat');
    }

    public function cetak($event_skemaID)
    {
        $data_sertifikat_peserta = DB::table('tb_sertifikat')
            ->join('tb_peserta', 'tb_sertifikat.peserta_id', '=', 'tb_peserta.id_peserta')
            ->join('tb_user', 'tb_peserta.user_id', '=', 'tb_user.id_user')
            ->join('tb_event_skema', 'tb_peserta.event_skema_id', '=', 'tb_event_skema.id_event_skema')
            ->join('tb_event', 'tb_event_skema.event_id', '=', 'tb_event.id_event')
            ->join('tb_jenis_event', 'tb_event.jenis_event_id', '=', 'tb_jenis_event.id_jenis_event')
            ->join('tb_skema', 'tb_event_skema.skema_id', '=', 'tb_skema.id_skema')
            ->join('tb_background', 'tb_event_skema.background_id', '=', 'tb_background.id_background')
            ->select(
                'tb_user.nama_lengkap',
                'tb_event.nama_event',
                'tb_jenis_event.nama_jenis_event',
                'tb_skema.nama_skema',
                'tb_background.nama_bg',
                'tb_background.orientasi_bg',
                'tb_background.path_bg',
                'tb_sertifikat.nomor_sertifikat',
                'tb_sertifikat.tgl_terbit',
                'tb_sertifikat.tgl_berakhir',
                'tb_sertifikat.masa_berlaku',
                'tb_sertifikat.nilai',
                'tb_sertifikat.keterangan'
            )
            ->where('tb_peserta.user_id', Auth::user()->id_user)
            ->where('tb_event_skema.id_event_skema', $event_skemaID)
            ->get();

        $data_penadatangan = DB::table('tb_event_skema')
            ->join('tb_penandatangan', 'tb_event_skema.id_event_skema', '=', 'tb_penandatangan.event_skema_id')
            ->join('tb_ttd', 'tb_penandatangan.ttd_id', '=', 'tb_ttd.id_ttd')
            ->select('tb_ttd.nama_ttd', 'tb_ttd.jabatan', 'tb_ttd.path_ttd')
            ->where('tb_penandatangan.event_skema_id', $event_skemaID)
            ->get();

        $templateBg = public_path($data_sertifikat_peserta[0]->path_bg);
        $fileName = 'Sertif-' . $data_sertifikat_peserta[0]->nomor_sertifikat . '.pdf';

        $pdf = "";
        if ($data_sertifikat_peserta[0]->orientasi_bg != 'landscape') {
            $pdf = PDF::loadView(
                'template_sertifikat.cetak.cetak_sertifikat_potrait',
                compact('data_sertifikat_peserta', 'data_penadatangan', 'templateBg')
            )->setPaper('a4', 'potrait');
        } else {
            $pdf = PDF::loadView(
                'template_sertifikat.cetak.cetak_sertifikat_landscape',
                compact('data_sertifikat_peserta', 'data_penadatangan', 'templateBg')
            )->setPaper('a4', 'landscape');
        }

        return $pdf->download($fileName);
    }

    public function show($eventID)
    {
        $previousUrl = url()->previous();
        $data_event = DB::table('tb_peserta')
            ->join('tb_event_skema', 'tb_peserta.event_skema_id', '=', 'tb_event_skema.id_event_skema')
            ->join('tb_event', 'tb_event_skema.event_id', '=', 'tb_event.id_event')
            ->join('tb_tempat', 'tb_event.tempat_id', '=', 'tb_tempat.id_tempat')
            ->select(
                'tb_event.nama_event',
                'tb_event.deskripsi',
                'tb_event.path_banner',
                'tb_event.tgl_mulai',
                'tb_event.tgl_berakhir',
                'tb_tempat.nama_tempat'
            )
            ->where('tb_peserta.user_id', Auth::user()->id_user)
            ->where('tb_event_skema.event_id', $eventID)
            ->first();

        $data_skema = DB::table('tb_peserta')
            ->join('tb_event_skema', 'tb_peserta.event_skema_id', '=', 'tb_event_skema.id_event_skema')
            ->join('tb_skema', 'tb_event_skema.skema_id', '=', 'tb_skema.id_skema')
            ->join('tb_event', 'tb_event_skema.event_id', '=', 'tb_event.id_event')
            ->join('tb_tempat', 'tb_event.tempat_id', '=', 'tb_tempat.id_tempat')

            ->leftJoin('tb_sertifikat', function ($join) {
                $join->on('tb_peserta.event_skema_id', '=', 'tb_sertifikat.event_skema_id')
                    ->on('tb_peserta.id_peserta', '=', 'tb_sertifikat.peserta_id');
            })

            ->select(
                'tb_event_skema.id_event_skema',
                'tb_skema.nama_skema',
                DB::raw('CASE WHEN tb_sertifikat.id_sertifikat IS NOT NULL THEN 1 ELSE 0 END as memiliki_sertifikat')
            )
            ->where('tb_peserta.user_id', Auth::user()->id_user)
            ->where('tb_event_skema.event_id', $eventID)
            ->get();

        $eventSkemaId = $data_skema->pluck('id_event_skema');
        $nilai_peserta_raw = DB::table('tb_peserta')
            ->join('tb_user', 'tb_peserta.user_id', '=', 'tb_user.id_user')
            ->join('tb_event_skema', 'tb_peserta.event_skema_id', '=', 'tb_event_skema.id_event_skema')

            ->leftJoinSub(function ($query) {
                $query->from('tb_nilai_peserta')
                    ->select(
                        'peserta_id',
                        DB::raw('count(nilai) as banyak_nilai'),
                        DB::raw('SUM(nilai) as total_nilai'),
                        DB::raw('ROUND(AVG(nilai)) as avg_nilai')
                    )
                    ->groupBy('peserta_id');
            }, 'nilai_stats', function ($join) {
                $join->on('tb_peserta.id_peserta', '=', 'nilai_stats.peserta_id');
            })

            ->select(
                'tb_event_skema.id_event_skema',
                'tb_peserta.id_peserta',
                'tb_user.id_user',
                'tb_user.nama_lengkap',
                'nilai_stats.banyak_nilai',
                'nilai_stats.total_nilai',
                'nilai_stats.avg_nilai'
            )
            ->whereIn('tb_peserta.event_skema_id', $eventSkemaId)
            ->where('tb_peserta.user_id', Auth::user()->id_user)
            ->orderBy('tb_peserta.id_peserta')
            ->get();

        $rentang_nilai_raw = DB::table('tb_rentang_nilai')
            ->join('tb_event_skema_rentang_nilai', 'tb_rentang_nilai.id_rentang_nilai', '=', 'tb_event_skema_rentang_nilai.rentang_nilai_id')
            ->select(
                'tb_event_skema_rentang_nilai.event_skema_id',
                'tb_rentang_nilai.nama_konversi_nilai',
                'tb_rentang_nilai.inisial_rentang_nilai',
                'tb_rentang_nilai.keterangan_rentang_nilai',
                'tb_rentang_nilai.rentang_atas',
                'tb_rentang_nilai.rentang_bawah'
            )
            ->whereIn('tb_event_skema_rentang_nilai.event_skema_id', $eventSkemaId)
            ->get();

        $nilai_peserta = $nilai_peserta_raw->map(function ($score) use ($rentang_nilai_raw) {
            $range = $rentang_nilai_raw->first(function ($range) use ($score) {
                return $score->avg_nilai >= $range->rentang_bawah && $score->avg_nilai <= $range->rentang_atas;
            });

            if ($range) {
                $score->keterangan_rentang_nilai = $range->keterangan_rentang_nilai;
                $score->inisial_rentang_nilai = $range->inisial_rentang_nilai;
                $score->nama_konversi_nilai = $range->nama_konversi_nilai;
            } else {
                $score->keterangan_rentang_nilai = null;
                $score->inisial_rentang_nilai = null;
                $score->nama_konversi_nilai = null;
            }
            return $score;

        });

        $data_gabungan = $data_skema->map(function ($skema) use ($nilai_peserta) {
            $event = $nilai_peserta->firstWhere('id_event_skema', $skema->id_event_skema);
            return (object) array_merge((array) $skema, (array) $event);
        });

        $banner = asset($data_event->path_banner);

        return view('user.sertifikat.rincian_sertifikat', compact(
            'data_event',
            'data_gabungan',
            'banner',
            'previousUrl'
        ));
    }

}
