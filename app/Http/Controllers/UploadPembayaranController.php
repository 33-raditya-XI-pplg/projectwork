<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Skema;
use Illuminate\Http\Request;
use App\Models\Upload_pembayaran;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UploadPembayaranController extends Controller
{

    public function index()
    {
        if (!in_array(auth()->user()->level, ['Admin', 'Pengguna'])) {
            return redirect()->back()->with('error', 'Role tidak dikenal.');
        }

        if (auth()->user()->level === 'Admin') {
            // Query Upload yang statusnya 'Menunggu'
            $uploadPending = DB::table('tb_event_skema')
                ->leftJoin('tb_event', 'tb_event_skema.event_id', '=', 'tb_event.id_event')
                ->leftJoin('tb_skema', 'tb_event_skema.skema_id', '=', 'tb_skema.id_skema')
                ->leftJoin('tb_upload_pembayaran', 'tb_event_skema.id_event_skema', '=', 'tb_upload_pembayaran.event_skema_id')
                ->leftJoin('tb_user', 'tb_upload_pembayaran.user_id', '=', 'tb_user.id_user')
                ->select(
                    'tb_upload_pembayaran.id_upload_pembayaran',
                    'tb_event_skema.id_event_skema',
                    'tb_skema.nama_skema',
                    'tb_event.nama_event',
                    'tb_upload_pembayaran.bukti_pembayaran',
                    'tb_upload_pembayaran.status_pembayaran',
                    'tb_event.tgl_mulai',
                    'tb_event.tgl_berakhir',
                    'tb_upload_pembayaran.user_id',
                    'tb_user.nama_lengkap'
                )
                ->where('tb_upload_pembayaran.status_pembayaran', 'Menunggu')
                ->where('tb_event.biaya_regis', '>', 0)
                ->get();

            // Query Semua Upload (termasuk yang sudah diverifikasi/ditolak)
            $uploadAll = DB::table('tb_event_skema')
                ->leftJoin('tb_event', 'tb_event_skema.event_id', '=', 'tb_event.id_event')
                ->leftJoin('tb_skema', 'tb_event_skema.skema_id', '=', 'tb_skema.id_skema')
                ->leftJoin('tb_upload_pembayaran', 'tb_event_skema.id_event_skema', '=', 'tb_upload_pembayaran.event_skema_id')
                ->leftJoin('tb_user', 'tb_upload_pembayaran.user_id', '=', 'tb_user.id_user')
                ->select(
                    'tb_upload_pembayaran.id_upload_pembayaran',
                    'tb_event_skema.id_event_skema',
                    'tb_skema.nama_skema',
                    'tb_event.nama_event',
                    'tb_upload_pembayaran.bukti_pembayaran',
                    'tb_upload_pembayaran.status_pembayaran',
                    'tb_event.tgl_mulai',
                    'tb_event.tgl_berakhir',
                    'tb_upload_pembayaran.user_id',
                    'tb_user.nama_lengkap'
                )
                ->where('tb_upload_pembayaran.status_pembayaran', 'Sudah Dibayar')
                ->where('tb_event.biaya_regis', '>', 0)
                ->get();

            $Title = 'Verifikasi Pembayaran';

            return view('admin.upload.index', compact('uploadPending', 'uploadAll', 'Title'));

        } elseif (auth()->user()->level === 'Pengguna') {
            $userId = auth()->user()->id_user;

          $upload = DB::table('tb_peserta')
    ->join('tb_event_skema', 'tb_peserta.event_skema_id', '=', 'tb_event_skema.id_event_skema')
    ->join('tb_event', 'tb_event_skema.event_id', '=', 'tb_event.id_event')
    ->join('tb_skema', 'tb_event_skema.skema_id', '=', 'tb_skema.id_skema')
    ->leftJoin('tb_upload_pembayaran', function ($join) use ($userId) {
        $join->on('tb_peserta.event_skema_id', '=', 'tb_upload_pembayaran.event_skema_id')
             ->where('tb_upload_pembayaran.user_id', '=', $userId);
    })
    ->where('tb_peserta.user_id', $userId)
    ->where('tb_event.biaya_regis', '>', 0)
    ->whereIn('tb_event.status', ['Publish'])
    ->select(
        'tb_event_skema.id_event_skema',
        'tb_event_skema.event_id',
        'tb_skema.nama_skema',
        'tb_event.nama_event',
        DB::raw('MAX(tb_upload_pembayaran.bukti_pembayaran) as bukti_pembayaran'),
        DB::raw('MAX(tb_upload_pembayaran.status_pembayaran) as status_pembayaran'),
        'tb_event.tgl_mulai',
        'tb_event.tgl_berakhir',
        'tb_event.status'
    )
    ->groupBy(
        'tb_event_skema.id_event_skema',
        'tb_event_skema.event_id',
        'tb_skema.nama_skema',
        'tb_event.nama_event',
        'tb_event.tgl_mulai',
        'tb_event.tgl_berakhir',
        'tb_event.status'
    )
    // ->orderByDesc('tb_upload_pembayaran.id_upload_pembayaran')
    ->get();

            $Title = 'Upload Pembayaran';
            // dd($upload);
            return view('user.upload.index', compact('upload', 'Title'));
        }
    }
    public function store(Request $request)
    {
        // Validasi file upload
        $request->validate(rules: [
            'upload_file' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Sesuaikan aturan sesuai kebutuhan
            'event_skema_id' => 'required|exists:tb_event_skema,id_event_skema', // Pastikan event_id valid
        ]);


        // Ambil user ID dan peserta ID dari user yang sedang login
        $userId = auth()->user()->id_user;

        // Ambil data peserta dari tabel tb_peserta berdasarkan user yang login
        $peserta = DB::table('tb_user')
            ->where('id_user', $userId)
            ->first();

        // dd($peserta);
        // Periksa apakah peserta ditemukan
        if (!$peserta) {
            return redirect()->back()->with('error', 'Data peserta tidak ditemukan.');
        }
        // Upload file ke penyimpanan (misal ke folder 'uploads')
        $path = $request->file('upload_file')->store('uploads', 'public');
        // Simpan data ke database
        $upload = Upload_pembayaran::create([
            'event_skema_id' => $request->event_skema_id,
            'user_id' => $userId,
            'status_pembayaran' => 'Menunggu',
            'bukti_pembayaran' => $path,
        ]);


        if ($upload) {
            return redirect()->back()->with('success', 'Pembayaran berhasil diunggah. Status: Menunggu');
        } else {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    public function updateStatus(Request $request, $id_upload_pembayaran)
    {
        // dd($request->all(), $id_upload_pembayaran);
        // dd($request);

        $upload = Upload_pembayaran::findOrFail($id_upload_pembayaran);
        $upload->status_pembayaran = $request->input('status');
        $upload->save();
        // dd($upload->status_pembayaran);

        if ($upload->status_pembayaran == 'Ditolak') {
            // Hapus data "Menunggu" dari tabel terkait, misalnya tabel tb_peserta
            
            $upload->status_pembayaran = 'Ditolak';
            $upload->save()
;

            // Tambahkan Alert jika pembayaran ditolak
            // Alert::error('Pembayaran Ditolak', 'Pembayaran telah ditolak dan data menunggu dihapus.');
        } elseif ($request->input('status') == 'Sudah Dibayar') {
            // Tambahkan Alert jika pembayaran diselesaikan
            // Alert::success('Pembayaran Diselesaikan', 'Pembayaran telah diselesaikan.');
        }
        //hapus database dengan status_belum dibayar
        DB::transaction(function () use ($upload, $id_upload_pembayaran) {
            DB::table('tb_upload_pembayaran')
                ->where('user_id', $upload->user_id)
                ->where('id_upload_pembayaran', $id_upload_pembayaran)
                ->where('status_pembayaran', 'Belum Dibayar')
                ->delete();
        });
        return redirect()->back();
    }

    public function getSkema($eventId)
    {
        // Ambil semua event skema yang memiliki id_event yang sama
        $events = DB::table('tb_event_skema')->where('event_id', $eventId)->get();
        // Cek apakah ada event yang ditemukan
        if ($events->isEmpty()) {
            return response()->json(['error' => 'Event tidak ditemukan.'], 404);
        }
        // Buat array untuk menyimpan skema yang terkait dengan event
        $allSkema = [];
        // Iterasi setiap event dan ambil skema yang terkait dengan skema_id
        foreach ($events as $event) {
            if ($event->skema_id) {
                $skema = DB::table('tb_skema')->where('id_skema', $event->skema_id)->first();
                if ($skema) {
                    $allSkema[] = $skema;
                }
            }
        }
        // Cek apakah skema ditemukan
        if (empty($allSkema)) {
            return response()->json(['error' => 'Tidak ada skema yang ditemukan untuk event terkait.'], 404);
        }
        return response()->json($allSkema); // Kembalikan semua skema yang ditemukan
    }

    public function cekPeserta($event_skema_id)
    {
        $userId = auth()->user()->id_user;
        $peserta = DB::table('tb_peserta')
            ->where('user_id', $userId)
            ->where('event_skema_id', $event_skema_id)
            ->first();
        if ($peserta) {
            return response()->json(['status' => true]);
        } else {
            return response()->json(['status' => false, 'message' => 'Anda belum terdaftar sebagai peserta pada event/skema ini.']);
        }
    }
}
