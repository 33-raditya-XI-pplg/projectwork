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
            ->where('tb_event.status', 'Berlangsung')
            ->join('tb_jenis_event', 'tb_event.jenis_event_id', '=', 'tb_jenis_event.id_jenis_event')
            ->join('tb_tempat', 'tb_event.tempat_id', '=', 'tb_tempat.id_tempat')
            ->paginate(9);

        $Title = 'Event';
        // dd($query->toSql(), $query->getBindings());
        return view('user.event.index', compact('data_event', 'data_jenis_event', 'data_tempat', 'Title'));
    }

    public function show($eventID)
    {
        confirmDelete('Hapus Nilai Peserta', 'Apakah kamu yakin untuk menghapus?'); // Include SweetAlert to View
        $userID = Auth::user()->id_user;

        $data_event = DB::table('tb_event_skema')
            ->join('tb_event', 'tb_event_skema.event_id', '=', 'tb_event.id_event')
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

        $Title = 'Rincian';
        $subtitle = 'Event';

        return view('user.event.rincian_event', compact('data_event', 'data_skema', 'banner', 'Title', 'subtitle'));
    }

    public function mendaftar(Request $request)
    {
        $userID = Auth::user()->id_user;

        $isRegistered = DB::table('tb_peserta')
            ->where('user_id', $userID)
            ->where('event_skema_id', $request->event_skema_id)
            ->exists();

        if ($isRegistered) {
            Alert::error('Gagal Mendaftar!', 'Anda sudah terdaftar di event ini');
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

        if ($eventSkema->biaya_regis > 0) {

            $uploadPembayaran = DB::table('tb_upload_pembayaran')
                ->where('user_id', $userID)
                ->where('event_skema_id', $eventSkema->id_event_skema)
                ->first();

            if (!$uploadPembayaran) {
                Alert::error('Gagal mendaftar!', 'Anda belum melakukan pembayaran untuk event ini.');
                return redirect()->back();
            }

            if ($uploadPembayaran->status_pembayaran !== 'Sudah Dibayar') {
                Alert::error('Gagal mendaftar!', 'Status pembayaran Anda belum terkonfirmasi.');
                return redirect()->back();
            }

            DB::table('tb_peserta')->insert([
                'user_id' => $userID,
                'event_skema_id' => $request->event_skema_id,
                'upload_pembayaran_id' => $uploadPembayaran->id_upload_pembayaran,
                'created_by' => $userID,
                'created_at' => now()
            ]);
        } else {
            DB::table('tb_peserta')->insert([
                'user_id' => $userID,
                'event_skema_id' => $request->event_skema_id,
                'created_by' => $userID,
                'created_at' => now()
            ]);
        }

        Alert::success('Berhasil Mendaftar!', 'Data berhasil ditambahkan.');
        return redirect()->back();
    }

}
