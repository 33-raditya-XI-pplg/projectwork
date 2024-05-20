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
        $data_sertifikat_peserta = DB::table('tb_sertifikat')
                    ->join('tb_peserta', 'tb_sertifikat.peserta_id', '=', 'tb_peserta.id_peserta')
                    ->join('tb_user', 'tb_peserta.user_id', '=', 'tb_user.id_user')
                    ->join('tb_event_skema', 'tb_peserta.event_skema_id', '=', 'tb_event_skema.id_event_skema')
                    ->join('tb_event', 'tb_event_skema.event_id', '=', 'tb_event.id_event')
                    ->join('tb_skema', 'tb_event_skema.skema_id', '=', 'tb_skema.id_skema')
                    ->select('tb_user.nama_lengkap',
                             'tb_event_skema.id_event_skema',
                             'tb_event.nama_event',
                             'tb_skema.nama_skema',
                             'tb_sertifikat.tgl_terbit', 'tb_sertifikat.tgl_berakhir'
                    )
                    ->where('tb_peserta.user_id', Auth::user()->id_user)
                    ->get();

        return view('user.sertifikat.index', compact('data_sertifikat_peserta'));
    }
    public function cetak1() // ==== Easter Egg ====
    {
        return view('user.sertifikat.cetak_sertifikat');
    }
    
    // public function cetak($event_skemaID) { 
    public function cetak($event_skemaID) { 
        $data_sertifikat_peserta = DB::table('tb_sertifikat')
                        ->join('tb_peserta', 'tb_sertifikat.peserta_id', '=', 'tb_peserta.id_peserta')
                        ->join('tb_user', 'tb_peserta.user_id', '=', 'tb_user.id_user')
                        ->join('tb_event_skema', 'tb_peserta.event_skema_id', '=', 'tb_event_skema.id_event_skema')
                        ->join('tb_event', 'tb_event_skema.event_id', '=', 'tb_event.id_event')
                        ->join('tb_jenis_event', 'tb_event.jenis_event_id', '=', 'tb_jenis_event.id_jenis_event')
                        ->join('tb_skema', 'tb_event_skema.skema_id', '=', 'tb_skema.id_skema')
                        ->join('tb_background', 'tb_event_skema.background_id', '=', 'tb_background.id_background')
                        ->select('tb_user.nama_lengkap',
                                 'tb_event.nama_event', 'tb_jenis_event.nama_jenis_event', 'tb_skema.nama_skema',
                                 'tb_background.nama_bg', 'tb_background.orientasi_bg', 'tb_background.path_bg',
                                 'tb_sertifikat.nomor_sertifikat', 
                                 'tb_sertifikat.tgl_terbit', 'tb_sertifikat.tgl_berakhir', 'tb_sertifikat.masa_berlaku',
                                 'tb_sertifikat.nilai', 'tb_sertifikat.keterangan' 
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
            $pdf = PDF::loadView('template_sertifikat.cetak.cetak_sertifikat_potrait', 
                compact('data_sertifikat_peserta', 'data_penadatangan', 'templateBg')
            )->setPaper('a4', 'potrait');
        } else {
            $pdf = PDF::loadView('template_sertifikat.cetak.cetak_sertifikat_landscape', 
                compact('data_sertifikat_peserta', 'data_penadatangan', 'templateBg')
            )->setPaper('a4', 'landscape');
        }

        return $pdf->download($fileName);
    }
}
