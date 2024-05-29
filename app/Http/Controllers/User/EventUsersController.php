<?php

namespace App\Http\Controllers\User;

use App\Models\Tempat;
use Carbon\Carbon;
use App\Models\Event;

use App\Models\Jenis_Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class EventUsersController extends Controller
{
    public function index(Request $request)
    {
        $data_jenis_event = Jenis_Event::get();
        $data_tempat = Tempat::get();
        $query = Event::query();

        if ($request->has('tgl_mulai') && $request->tgl_mulai) {
            $query->where('tb_event.tgl_mulai', '>=', Carbon::parse($request->tgl_mulai));
        }

        if ($request->has('tgl_berakhir') && $request->tgl_berakhir) {
            $query->where('tb_event.tgl_berakhir', '<=', Carbon::parse($request->tgl_berakhir));
        }

        if ($request->has('nama_jenis_event') && $request->nama_jenis_event) {
            $query->where('tb_jenis_event.id_jenis_event', 'like', '%' . $request->nama_jenis_event . '%');
        }

        if ($request->has('nama_tuk') && $request->nama_tuk) {
            $query->where('tb_tempat.id_tempat', 'like', '%' . $request->nama_tuk . '%');
        }

        $data_event = $query->where('tb_event.visibilitas', 'publik')
                        ->join('tb_jenis_event', 'tb_event.jenis_event_id', '=', 'tb_jenis_event.id_jenis_event')
                        ->join('tb_tempat', 'tb_event.tempat_id', '=', 'tb_tempat.id_tempat')
                        ->paginate(9);

        return view('user.event.index', compact('data_event', 'data_jenis_event', 'data_tempat'));
    }

    public function show($eventID)
    {
        confirmDelete('Hapus Nilai Peserta', 'Apakah kamu yakin untuk menghapus?'); // Include SweetAlert to View
        $userID = Auth::user()->id_user;

        $data_event = DB::table('tb_event_skema')
                    ->join('tb_event', 'tb_event_skema.event_id', '=', 'tb_event.id_event')
                    ->join('tb_tempat', 'tb_event.tempat_id', '=', 'tb_tempat.id_tempat')
                    ->select('tb_event.nama_event', 'tb_event.deskripsi', 'tb_event.path_banner',
                             'tb_event.tgl_mulai', 'tb_event.tgl_berakhir',
                             'tb_tempat.nama_tempat'
                    )
                    ->where('tb_event_skema.event_id', $eventID)
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

    public function mendaftar(Request $request)
    {
        $userID = Auth::user()->id_user;

        $isRegistered = DB::table('tb_peserta')
            ->where('user_id', $userID)
            ->where('event_skema_id', $request->event_skema_id)
            ->exists();

        if ($isRegistered) {
            Alert::error('Gagal Mendaftar!');
            return redirect()->back();
        }

        DB::table('tb_peserta')->insert([
            'user_id' => $userID,
            'event_skema_id' => $request->event_skema_id,
            'created_by' => $userID,
            'created_at' => now()
        ]);

        Alert::success('Berhasil Mendaftar!', 'Data berhasil ditambahkan.');
        return redirect()->back();
    }

}
