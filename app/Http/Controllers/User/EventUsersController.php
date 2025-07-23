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

        $userID = Auth::user()->id_user;
        $isRegistered = DB::table('tb_peserta')
            ->where('user_id', $userID)
            // ->where('event_skema_id', $request->event_skema_id)
            ->exists();

            // dd($isRegistered);

            // dd($route);

        $data_jenis_event = Jenis_Event::get();
        $data_tempat = Tempat::get();
        $query = Event::query();

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

        $data_event = $query
            ->where('tb_event.visibilitas', 'publik')
            ->whereIn('tb_event.status', ['Publish'])
            ->join('tb_jenis_event', 'tb_event.jenis_event_id', '=', 'tb_jenis_event.id_jenis_event')
            ->join('tb_tempat', 'tb_event.tempat_id', '=', 'tb_tempat.id_tempat')
            ->paginate(9);

        $Title = 'Event';
        // dd($query->toSql(), $query->getBindings());
        // dd($data_event);
        if($route == 'user/event-user'){
            // $route = 'user.event.index';
            return view('user.event.index', compact('data_event', 'data_jenis_event', 'data_tempat', 'Title', 'route', 'isRegistered'));
        }else if($route == 'user/follow-event'){
            // $route = 'user.event.follow_event';
            return view('user.event.follow_event', compact('data_event', 'data_jenis_event', 'data_tempat', 'Title', 'route', 'isRegistered'));
        }else{
            Alert::error('Error', 'Halaman tidak ditemukan.');
            return redirect()->back();
        }

    }

    public function show($eventID)
    {
        $route = Route::current();
        // dd($route);
        // $route = $route->uri;

        confirmDelete('Hapus Nilai Peserta', 'Apakah kamu yakin untuk menghapus?'); // Include SweetAlert to View
        $userID = Auth::user()->id_user;

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

        $data_skema = DB::table('tb_event')
            ->join('tb_event_skema', 'tb_event.id_event', '=', 'tb_event_skema.event_id')
            ->join('tb_skema', 'tb_event_skema.skema_id', '=', 'tb_skema.id_skema')
            ->join('tb_tempat', 'tb_event.tempat_id', '=', 'tb_tempat.id_tempat')

            ->leftJoin('tb_peserta', 'tb_event_skema.id_event_skema', '=', 'tb_peserta.event_skema_id')
            ->leftJoin('tb_sertifikat', 'tb_peserta.id_peserta', '=', 'tb_sertifikat.peserta_id')


            ->select(
                'tb_event_skema.id_event_skema',
                'tb_skema.nama_skema',
                'tb_peserta.id_peserta',
                'tb_sertifikat.peserta_id as peserta_sertifikat_id',
                DB::raw('CASE WHEN tb_peserta.id_peserta IS NOT NULL THEN 1 ELSE 0 END as telah_terdaftar')
            )
            ->where('tb_event_skema.event_id', $eventID)
            ->get();
        // dd($data_skema);

        $banner = asset($data_event->path_banner);

        $Title = 'Rincian';
        $subtitle = 'Event';

        // dd($data_skema);

        if($route->uri == 'user/event-user/{event_user}'){
            return view('user.event.rincian_event', compact('data_event', 'data_skema', 'banner', 'Title', 'subtitle'));
        }
        elseif($route->uri == 'user/follow-event/{id}'){
            return view('user.event.rincian_follow_event', compact('data_event', 'data_skema', 'banner', 'Title', 'subtitle'));
        }
        else{
            Alert::error('Error', 'Halaman tidak ditemukan.');
            return redirect()->back();
        }
    }

    public function mendaftar(Request $request)
    {
        $userID = Auth::user()->id_user;

        // Cek apakah sudah terdaftar
        $isRegistered = DB::table('tb_peserta')
            ->where('user_id', $userID)
            ->where('event_skema_id', $request->event_skema_id)
            ->exists();

        if ($isRegistered) {
            Alert::error('Gagal Mendaftar!', 'Anda sudah terdaftar di event ini.');
            return redirect()->back();
        }

        // Cek detail skema
        $eventSkema = DB::table('tb_event_skema')
            ->join('tb_event', 'tb_event_skema.event_id', '=', 'tb_event.id_event')
            ->where('id_event_skema', $request->event_skema_id)
            ->select('tb_event_skema.*', 'tb_event.biaya_regis')
            ->first();

        if (!$eventSkema) {
            Alert::error('Gagal Mendaftar!', 'Event skema tidak ditemukan.');
            return redirect()->back();
        }

        // Simpan ke tabel peserta, tanpa cek status pembayaran
        $pesertaId = DB::table('tb_peserta')->insertGetId([
            'user_id' => $userID,
            'event_skema_id' => $request->event_skema_id,
            'created_by' => $userID,
            'created_at' => now()
        ]);

        // Jika event berbayar, arahkan ke halaman upload bukti pembayaran
        if ($eventSkema->biaya_regis > 0) {
            Alert::success('Berhasil Mendaftar!', 'Silakan unggah bukti pembayaran.');
            return redirect()->route('uploadPembayaran-user.index'); // atau route ke halaman upload kamu
        }

        // Jika gratis, selesai
        Alert::success('Berhasil Mendaftar!', 'Anda berhasil terdaftar.');
        return redirect()->back();
    }
}
