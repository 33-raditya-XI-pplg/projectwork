<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Event;

class PenilaianController extends Controller
{
    public function index()
    {
        $event = Event::all();
        return view('admin.penilaian.index', compact('event'));
    }

    public function getEventData($id) 
    {
        $data = DB::table('tb_event_skema')
                    ->join('tb_skema', 'tb_event_skema.skema_id', '=', 'tb_skema.id_skema')
                    ->select('tb_skema.id_skema', 'tb_skema.nama_skema')
                    ->where('tb_event_skema.event_id', $id)
                    ->get();
        
        return response()->json($data);
    }

    public function getSkemaData($id) 
    {
        $data_skema = DB::table('tb_event_skema')
                    ->join('tb_event', 'tb_event_skema.event_id', '=', 'tb_event.id_event')
                    ->join('tb_skema', 'tb_event_skema.skema_id', '=', 'tb_skema.id_skema')
                    ->join('tb_jenis_event', 'tb_event.jenis_event_id', '=', 'tb_jenis_event.id_jenis_event')
                    ->select('tb_event_skema.id_event_skema', 'tb_event.id_event', 'tb_event.nama_event',
                             'tb_event.tgl_mulai', 'tb_event.tgl_berakhir', 'tb_event.status', 
                             'tb_jenis_event.nama_jenis_event', 'tb_skema.nama_skema')
                    ->where('tb_event_skema.event_id', $id)
                    ->get();

        $data_peserta = DB::table('tb_daftar_peserta')
                    ->join('tb_user', 'tb_daftar_peserta.user_id', '=', 'tb_user.id_user')
                    ->join('tb_event_skema', 'tb_daftar_peserta.event_skema_id', '=', 'tb_event_skema.id_event_skema')
                    ->select('tb_event_skema.id_event_skema', 'tb_user.nama_lengkap')
                    ->where('tb_daftar_peserta.event_skema_id', '=', $id)
                    ->get();

        return response()->json([
            'data_skema' => $data_skema, 
            'data_peserta' => $data_peserta
        ]);
    }

    // public function getData(Request $request)
    // {        
    //     // dd($request);
    //     $event = Event::get();
    //     $skema = Skema::get();

    //     $eventId = $request->input('event_select');
    //     $skemaId = $request->input('skema_select');

    //     $data_event_skema = DB::table('tb_event_skema')
    //                 ->join('tb_event', 'tb_event_skema.event_id', '=', 'tb_event.id_event')
    //                 ->join('tb_jenis_event', 'tb_event.jenis_event_id', '=', 'tb_jenis_event.id_jenis_event')
    //                 ->select('tb_event_skema.id_event_skema', 'tb_event.id_event', 'tb_event.nama_event', 'tb_event.tgl_mulai', 'tb_event.tgl_berakhir', 'tb_event.status', 'tb_jenis_event.nama_jenis_event')
    //                 ->where('tb_event_skema.event_id', $eventId)
    //                 ->where('tb_event_skema.skema_id', $skemaId)
    //                 ->get();
                    
    //     // dd($data_event_skema);
        // $data_daftar_peserta = DB::table('tb_daftar_peserta')
        //             ->join('tb_user', 'tb_daftar_peserta.user_id', '=', 'tb_user.id_user')
        //             ->join('tb_event_skema', 'tb_daftar_peserta.event_skema_id', '=', 'tb_event_skema.id_event_skema')
        //             ->select('tb_user.nama_lengkap', 'tb_event_skema.id_event_skema')
        //             ->where('tb_daftar_peserta.event_skema_id', '=', $data_event_skema->value('id_event_skema'))
        //             ->get();
        // dd($data_peserta);

    //     return view('admin.penilaian.index', compact('event', 'skema', 'data_event_skema', 'data_daftar_peserta'));
    // }

    public function create()
    {
        return view('admin.penilaian.inputnilai');
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }

}
