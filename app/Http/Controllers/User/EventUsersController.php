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
use Illuminate\Support\Facades\Route;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Event_Skema;

class EventUsersController extends Controller
{
    public function index(Request $request)
    {

    $route = Route::current();
    $route = $route->uri;
    $isEventUserRoute = request()->is('user/event-user*');
    $isFollowEventRoute = request()->is('user/follow-event*');

        $userID = Auth::user()->id_user;

        $registeredEventIds = DB::table('tb_peserta')
            ->join('tb_event_skema', 'tb_peserta.event_skema_id', '=', 'tb_event_skema.id_event_skema')
            ->where('tb_peserta.user_id', $userID)
            ->pluck('tb_event_skema.event_id')
            ->unique()
            ->toArray();

            // dd($isRegistered);

            // dd($route);

        $data_jenis_event = Jenis_Event::get();
        $data_tempat = Tempat::get();

        $query = Event::query()
            ->join('tb_jenis_event', 'tb_event.jenis_event_id', '=', 'tb_jenis_event.id_jenis_event')
            ->join('tb_tempat', 'tb_event.tempat_id', '=', 'tb_tempat.id_tempat')
            ->select('tb_event.*', 'tb_jenis_event.nama_jenis_event', 'tb_tempat.nama_tempat');

        if ($request->has('tgl_mulai') && $request->tgl_mulai) {
            $query->whereDate('tb_event.tgl_mulai', '>=', Carbon::parse($request->tgl_mulai)->toDateString());
        }

        if ($request->has('tgl_berakhir') && $request->tgl_berakhir) {
            $query->whereDate('tb_event.tgl_berakhir', '<=', Carbon::parse($request->tgl_berakhir)->toDateString());
        }

        if ($request->has('nama_jenis_event') && $request->nama_jenis_event) {
            $query->where('tb_event.jenis_event_id', $request->nama_jenis_event);
        }

        if ($request->has('nama_tuk') && $request->nama_tuk) {
            $query->where('tb_event.tempat_id', $request->nama_tuk);
        }
        // dd($request->all());


        if ($isEventUserRoute) {
            // Show both 'Publish' and 'Berlangsung' events on public listing
            $query->where('tb_event.visibilitas', 'publik')
                  ->whereIn('tb_event.status', ['Publish', 'Berlangsung']);
        } elseif ($isFollowEventRoute) {
            if (empty($registeredEventIds)) {
                $query->whereRaw('1 = 0');
            } else {
                $query->whereIn('tb_event.id_event', $registeredEventIds)
                      ->whereIn('tb_event.status', ['Berlangsung', 'Selesai']);
            }
        }

        $data_event = $query->paginate(9);

        $Title = 'Event';
        // dd($query->toSql(), $query->getBindings());
        // dd($data_event[0]->status);
        if($isEventUserRoute){

            return view('user.event.index', compact('data_event', 'data_jenis_event', 'data_tempat', 'Title', 'route', 'registeredEventIds'));
        }else if($isFollowEventRoute){

            return view('user.event.follow_event', compact('data_event', 'data_jenis_event', 'data_tempat', 'Title', 'route', 'registeredEventIds'));
        }else{
            Alert::error('Error', 'Halaman tidak ditemukan.');
            return redirect()->back();
        }

    }

    public function show($eventID)
{
    $route = Route::current();
    confirmDelete('Hapus Nilai Peserta', 'Apakah kamu yakin untuk menghapus?');
    $userID = Auth::user()->id_user;

    // Ambil data event
    $data_event = Event::findOrFail($eventID)
        ->join('tb_tempat', 'tb_event.tempat_id', '=', 'tb_tempat.id_tempat')
        ->select(
            'tb_event.nama_event',
            'tb_event.deskripsi',
            'tb_event.path_banner',
            'tb_event.tgl_mulai',
            'tb_event.biaya_regis',
            'tb_event.tgl_berakhir',
            'tb_tempat.nama_tempat'
        )
        ->where('tb_event.id_event', $eventID)
        ->first();

    $data_skema = DB::table('tb_event_skema')
        ->join('tb_skema', 'tb_event_skema.skema_id', '=', 'tb_skema.id_skema')
        ->leftJoin('tb_peserta', function($join) use ($userID) {
            $join->on('tb_event_skema.id_event_skema', '=', 'tb_peserta.event_skema_id')
                 ->where('tb_peserta.user_id', '=', $userID);
        })
        ->leftJoin('tb_sertifikat', 'tb_peserta.id_peserta', '=', 'tb_sertifikat.peserta_id')
        ->leftJoin('tb_laporan_perkembangan', function($join) {
            $join->on('tb_laporan_perkembangan.event_skema_id', '=', 'tb_event_skema.id_event_skema')
                 ->on('tb_laporan_perkembangan.peserta_id', '=', 'tb_peserta.id_peserta');
        })
        ->leftJoin('tb_nilai_peserta', function($join) {
            $join->on('tb_nilai_peserta.peserta_id', '=', 'tb_peserta.id_peserta')
                 ->on('tb_nilai_peserta.event_skema_id', '=', 'tb_event_skema.id_event_skema');
        })
        ->select(
            'tb_event_skema.id_event_skema',
            'tb_skema.nama_skema',
            'tb_peserta.id_peserta',
            'tb_sertifikat.id_sertifikat',
            'tb_sertifikat.nomor_sertifikat',
            'tb_laporan_perkembangan.id_laporan_perkembangan',
            'tb_nilai_peserta.id_nilai_peserta',
            DB::raw('CASE WHEN tb_peserta.id_peserta IS NOT NULL THEN 1 ELSE 0 END as telah_terdaftar')
        )
        ->where('tb_event_skema.event_id', $eventID)
        ->groupBy('tb_event_skema.id_event_skema', 'tb_skema.nama_skema', 'tb_peserta.id_peserta', 'tb_sertifikat.id_sertifikat', 'tb_sertifikat.nomor_sertifikat', 'tb_laporan_perkembangan.id_laporan_perkembangan', 'tb_nilai_peserta.id_nilai_peserta')
        ->get();

    $data_skema = $data_skema->groupBy('id_event_skema')->map(function ($items) {
        $first = $items->first();
        return [
            'id_event_skema' => $first->id_event_skema,
            'nama_skema' => $first->nama_skema,
            'id_peserta' => $first->id_peserta,
            'id_sertifikat' => $first->id_sertifikat,
            'nomor_sertifikat' => $first->nomor_sertifikat,
            'id_laporan_perkembangan' => $first->id_laporan_perkembangan,
            'telah_terdaftar' => $first->telah_terdaftar,
            'id_nilai_peserta' => $items->pluck('id_nilai_peserta')->filter()->values(),
        ];
    })->values();

    // dd($data_skema);

    $banner = asset($data_event->path_banner);
    $Title = 'Rincian';
    $subtitle = 'Event';

    if ($route->uri == 'user/event-user/{event_user}') {
        return view('user.event.rincian_event', compact('data_event', 'data_skema', 'banner', 'Title', 'subtitle'));
    } elseif ($route->uri == 'user/follow-event/{id}') {
        return view('user.event.rincian_follow_event', compact('data_event', 'data_skema', 'banner', 'Title', 'subtitle'));
    } else {
        Alert::error('Error', 'Halaman tidak ditemukan.');
        return redirect()->back();
    }
}


    public function mendaftar(Request $request)
    {
        $userID = Auth::user()->id_user;

        $isRegistered = DB::table('tb_peserta')
            ->where('user_id', $userID)
            ->where('event_skema_id', $request->event_skema_id)
            ->exists();

        if ($isRegistered) {
            Alert::error('Gagal Mendaftar!', 'Anda sudah terdaftar di event ini.');
            return redirect()->back();
        }

        $eventSkema = DB::table('tb_event_skema')
            ->join('tb_event', 'tb_event_skema.event_id', '=', 'tb_event.id_event')
            ->where('id_event_skema', $request->event_skema_id)
            ->select('tb_event_skema.*', 'tb_event.biaya_regis')
            ->first();

        if (!$eventSkema) {
            Alert::error('Gagal Mendaftar!', 'Event skema tidak ditemukan.');
            return redirect()->back();
        }

        $pesertaId = DB::table('tb_peserta')->insertGetId([
            'user_id' => $userID,
            'event_skema_id' => $request->event_skema_id,
            'created_by' => $userID,
            'created_at' => now()
        ]);

        if ($eventSkema->biaya_regis > 0) {
            Alert::success('Berhasil Mendaftar!', 'Silakan unggah bukti pembayaran.');
            return redirect()->route('uploadPembayaran-user.index');
        }

        Alert::success('Berhasil Mendaftar!', 'Anda berhasil terdaftar.');
        return redirect()->back();
    }
}
