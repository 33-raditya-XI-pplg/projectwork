<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RincianSertifikatController extends Controller
{
    public function show($event_skemaID)
    {
        $data_skema = DB::table('tb_peserta')
                    ->join('tb_event_skema', 'tb_peserta.event_skema_id', '=', 'tb_event_skema.id_event_skema')
                    ->join('tb_skema', 'tb_event_skema.skema_id', '=', 'tb_skema.id_skema')
                    ->join('tb_event', 'tb_event_skema.event_id', '=', 'tb_event.id_event')
                    ->join('tb_tempat', 'tb_event.tempat_id', '=', 'tb_tempat.id_tempat')
                    ->select('tb_event.nama_event', 'tb_event.deskripsi', 'tb_event.path_banner',
                             'tb_event.tgl_mulai', 'tb_event.tgl_berakhir',
                             'tb_skema.nama_skema',
                             'tb_tempat.nama_tempat'
                    )
                    ->where('tb_peserta.user_id', Auth::user()->id_user)
                    ->where('tb_event_skema.id_event_skema', $event_skemaID)
                    ->first();
        
        $banner = asset($data_skema->path_banner);

        return view('user.sertifikat.rincian_sertifikat', compact('data_skema', 'banner'));
    }
}
