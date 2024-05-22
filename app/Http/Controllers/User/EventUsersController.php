<?php

namespace App\Http\Controllers\User;

use App\Models\Event;
use App\Models\Instansi;
use App\Models\Jenis_Event;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class EventUsersController extends Controller
{
    public function index()
    {
        $data_jenis_event = Jenis_Event::get();
        $data_instansi = Instansi::get();
        $data_event = Event::paginate(9);
        
        return view('user.event.index', compact('data_jenis_event', 'data_instansi', 'data_event'));
    }

    public function show($eventID)
    {
        $userID = Auth::user()->id_user;
        $data_event = DB::table('tb_peserta')
                    ->join('tb_event_skema', 'tb_peserta.event_skema_id', '=', 'tb_event_skema.id_event_skema')
                    ->join('tb_event', 'tb_event_skema.event_id', '=', 'tb_event.id_event')
                    ->join('tb_tempat', 'tb_event.tempat_id', '=', 'tb_tempat.id_tempat')
                    ->select('tb_event.nama_event', 'tb_event.deskripsi', 'tb_event.path_banner',
                             'tb_event.tgl_mulai', 'tb_event.tgl_berakhir',
                             'tb_tempat.nama_tempat'
                    )
                    ->where('tb_peserta.user_id', Auth::user()->id_user)
                    ->where('tb_event_skema.event_id', $eventID)
                    ->groupBy('tb_event.id_event')
                    ->first();

        $data_skema = DB::table('tb_event')
                        ->join('tb_event_skema', 'tb_event.id_event', '=', 'tb_event_skema.event_id')
                        ->join('tb_skema', 'tb_event_skema.skema_id', '=', 'tb_skema.id_skema')
                        ->join('tb_tempat', 'tb_event.tempat_id', '=', 'tb_tempat.id_tempat')

                        ->leftJoin('tb_peserta', function ($join) use ($userID) {
                            $join->on('tb_event_skema.id_event_skema', '=', 'tb_peserta.event_skema_id')
                                 ->where('tb_peserta.user_id', '=', $userID);
                        })

                        ->select(
                            'tb_event_skema.id_event_skema',
                            'tb_skema.nama_skema',
                            DB::raw('CASE WHEN tb_peserta.id_peserta IS NOT NULL THEN 1 ELSE 0 END as telah_terdaftar')
                        )
                        ->where('tb_event_skema.event_id', $eventID)
                        ->get();

        $banner = asset($data_event->path_banner);
        
        return view('user.event.rincian_event', compact('data_event', 'data_skema', 'banner'));
    }

}
