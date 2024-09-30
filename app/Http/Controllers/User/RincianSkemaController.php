<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RincianSkemaController extends Controller
{
    public function rincian_skema($event_skemaID)
    {
        $previousUrl = url()->previous();
        $data_sub_skema = DB::table('tb_event_skema')
            ->join('tb_skema', 'tb_event_skema.skema_id', '=', 'tb_skema.id_skema')
            ->join('tb_sub_skema', 'tb_skema.id_skema', '=', 'tb_sub_skema.skema_id')
            ->select('tb_sub_skema.judul_sub')
            ->where('tb_event_skema.id_event_skema', $event_skemaID)
            ->get();

        $data_skema = DB::table('tb_event_skema')
            ->join('tb_skema', 'tb_event_skema.skema_id', '=', 'tb_skema.id_skema')
            ->join('tb_event', 'tb_event_skema.event_id', '=', 'tb_event.id_event')
            ->join('tb_tempat', 'tb_event.tempat_id', '=', 'tb_tempat.id_tempat')
            ->select(
                'tb_event.id_event',
                'tb_event.nama_event',
                'tb_event.deskripsi',
                'tb_event.path_banner',
                'tb_event.tgl_mulai',
                'tb_event.tgl_berakhir',
                'tb_skema.nama_skema',
                'tb_tempat.nama_tempat'
            )
            ->where('tb_event_skema.id_event_skema', $event_skemaID)
            ->first();

        $data_penguji = DB::table('tb_event_skema')
            ->join('tb_menguji', 'tb_event_skema.id_event_skema', '=', 'tb_menguji.event_skema_id')
            ->join('tb_user', 'tb_menguji.user_id', '=', 'tb_user.id_user')
            ->select('tb_user.nama_lengkap', 'tb_user.type_penguji')
            ->where('tb_event_skema.id_event_skema', $event_skemaID)
            ->get();

        $Title = 'Event';
        $subtitle = 'Skema';
        $subTitle = 'Rincian';
        return view('user.skema.rincian_skema', compact('data_sub_skema', 'data_skema', 'data_penguji', 'previousUrl', 'Title', 'subtitle', 'subTitle'));
    }
}
