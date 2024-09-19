<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Upload_pembayaran;

class UploadPembayaranController extends Controller
{

    public function index()
    {
        if (!in_array(auth()->user()->level, ['Admin', 'Pengguna'])) {
            return redirect()->back()->with('error', 'Role tidak dikenal.');
        }

        if (auth()->user()->level === 'Admin') {
            $upload = \DB::table('tb_event')
                ->leftJoin('tb_upload_pembayaran', 'tb_event.id_event', '=', 'tb_upload_pembayaran.event_id')
                ->leftJoin('tb_user', 'tb_upload_pembayaran.user_id', '=', 'tb_user.id_user')
                ->select(
                    'tb_upload_pembayaran.id_upload_pembayaran',
                    'tb_event.nama_event',
                    'tb_upload_pembayaran.bukti_pembayaran',
                    'tb_upload_pembayaran.status_pembayaran',
                    'tb_event.tgl_mulai',
                    'tb_event.tgl_berakhir',
                    'tb_upload_pembayaran.user_id',
                    'tb_user.nama_lengkap',
                )
                ->whereIn('tb_upload_pembayaran.status_pembayaran', ['Menunggu', 'Sudah Dibayar'])
                ->get();
            // dd($upload);
            return view('admin.upload.index', compact('upload'));
        } elseif (auth()->user()->level === 'Pengguna') {
            $userId = auth()->user()->id_user;
            // Query khusus user, misal event yang sudah dibayar
            $upload = \DB::table('tb_event')
                ->leftJoin('tb_upload_pembayaran', function ($join) use ($userId) {
                    $join->on('tb_event.id_event', '=', 'tb_upload_pembayaran.event_id')
                        ->where('tb_upload_pembayaran.user_id', '=', $userId);
                })
                ->select(
                    'tb_event.id_event',
                    'tb_event.nama_event',
                    'tb_upload_pembayaran.bukti_pembayaran',
                    'tb_upload_pembayaran.status_pembayaran',
                    'tb_event.tgl_mulai',
                    'tb_event.tgl_berakhir',

                )
                // ->whereNotNull('tb_upload_pembayaran.bukti_pembayaran')
                ->get();
            return view('user.upload.index', compact('upload'));
        }
        // dd($upload);

    }
    public function store(Request $request)
    {
        // Validasi file upload
        $request->validate(rules: [
            'upload_file' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Sesuaikan aturan sesuai kebutuhan
            'event_id' => 'required|exists:tb_event,id_event', // Pastikan event_id valid
        ]);


        // Ambil user ID dan peserta ID dari user yang sedang login
        $userId = auth()->user()->id_user;

        // Ambil data peserta dari tabel tb_peserta berdasarkan user yang login
        $peserta = \DB::table('tb_user')
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
        Upload_pembayaran::create([
            'event_id' => $request->event_id,
            'user_id' => $userId,
            'status_pembayaran' => 'Menunggu',
            'bukti_pembayaran' => $path,
        ]);

        return redirect()->back()->with('success', 'Pembayaran berhasil diunggah. Status: Menunggu');
    }

    public function updateStatus(Request $request, $id_upload_pembayaran)
    {
        // dd($request->all(), $id_upload_pembayaran);
        $request->validate([
            'status' => 'required|in:Sudah Dibayar',
        ]);

        $upload = Upload_pembayaran::findOrFail($id_upload_pembayaran);

        $upload->status_pembayaran = $request->input('status');
        $upload->save();

        return redirect()->back()->with('success', 'Status pembayaran berhasil diperbarui.');
    }
}
