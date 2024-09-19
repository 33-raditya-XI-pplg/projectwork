<?php

namespace App\Http\Controllers;

use App\Models\LaporanPerkembangan;
use App\Models\Event_Skema;
use App\Models\Sub_Skema;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanPerkembanganController extends Controller
{
    public function index()
    {
        $events = Event_Skema::all(); // Ganti nama variabel ke $events
        confirmDelete('Hapus Laporan Perkembangan', 'Apakah kamu yakin untuk menghapus?');
        return view('admin.laporanperkembangan.index', compact('events')); // Kirim $events ke view
    }
    

    public function fetchEventData($id)
    {
        $data = DB::table('tb_event_skema')
                    ->join('tb_skema', 'tb_event_skema.skema_id', '=', 'tb_skema.id_skema')
                    ->select('tb_skema.id_skema', 'tb_skema.nama_skema')
                    ->where('tb_event_skema.event_id', $id)
                    ->get();

        return response()->json([
            'data' => $data
        ]);
    }

    public function fetchSkemaData($id)
    {        
        $data_skema = Event_Skema::join('tb_event', 'tb_event_skema.event_id', '=', 'tb_event.id_event')
                    ->join('tb_skema', 'tb_event_skema.skema_id', '=', 'tb_skema.id_skema')
                    ->join('tb_tempat', 'tb_event.tempat_id', '=', 'tb_tempat.id_tempat')
                    ->join('tb_jenis_event', 'tb_event.jenis_event_id', '=', 'tb_jenis_event.id_jenis_event')
                    ->select('tb_event_skema.id_event_skema', 'tb_event.id_event', 'tb_event.nama_event',
                             'tb_event.tgl_mulai', 'tb_event.tgl_berakhir', 'tb_event.status', 
                             'tb_jenis_event.nama_jenis_event', 'tb_skema.nama_skema', 'tb_tempat.nama_tempat')
                    ->where('tb_event_skema.skema_id', $id)
                    ->first();

        $data_sub_skema = DB::table('tb_event_skema')
                    ->join('tb_event', 'tb_event_skema.event_id', '=', 'tb_event.id_event')
                    ->join('tb_skema', 'tb_event_skema.skema_id', '=', 'tb_skema.id_skema')
                    ->join('tb_sub_skema', 'tb_skema.id_skema', '=', 'tb_sub_skema.skema_id')
                    ->select('tb_event_skema.id_event_skema', 'tb_sub_skema.id_sub_skema', 'tb_sub_skema.judul_sub')
                    ->where('tb_event_skema.skema_id', $id)
                    ->get();

        $data_laporan_perkembangan = DB::table('tb_laporan_perkembangan')
                            ->join('tb_user', 'tb_laporan_perkembangan.created_by', '=', 'tb_user.id_user')
                            ->join('tb_sub_skema', 'tb_laporan_perkembangan.sub_skema_id', '=', 'tb_sub_skema.id_sub_skema')
                            ->join('tb_event_skema', 'tb_laporan_perkembangan.event_skema_id', '=', 'tb_event_skema.id_event_skema')
                            ->select('tb_laporan_perkembangan.id', 'tb_user.nama_lengkap', 'tb_sub_skema.judul_sub', 'tb_laporan_perkembangan.catatan', 'tb_laporan_perkembangan.tanggal')
                            ->where('tb_laporan_perkembangan.event_skema_id', $data_skema->id_event_skema)
                            ->orderBy('tb_user.id_user', 'asc')
                            ->get();

        return response()->json([
            'data_skema' => $data_skema, 
            'data_sub_skema' => $data_sub_skema, 
            'data_laporan_perkembangan' => $data_laporan_perkembangan
        ]);
    }

    public function fetchLaporanData($id)
    {
        $data_laporan = LaporanPerkembangan::with(['user', 'subSkema', 'eventSkema'])
                            ->where('id', $id)
                            ->first();

        return response()->json([
            'data_laporan' => $data_laporan
        ]);
    }

    public function create()
    {
        return view('admin.laporanperkembangan.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'event_skema_id' => 'required|exists:tb_event_skema,id_event_skema',
            'sub_skema_id' => 'required|exists:tb_sub_skema,id_sub_skema',
            'catatan' => 'required|string',
            'tanggal' => 'required|date',
        ]);

        DB::beginTransaction();

        try {
            LaporanPerkembangan::create([
                'event_skema_id' => $validatedData['event_skema_id'],
                'sub_skema_id' => $validatedData['sub_skema_id'],
                'catatan' => $validatedData['catatan'],
                'tanggal' => $validatedData['tanggal'],
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Laporan perkembangan berhasil disimpan']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => 'Gagal menyimpan laporan perkembangan', 'error' => $e->getMessage()]);
        }
    }

    public function destroy(Request $request)
    {
        $id = $request->id;

        try {
            LaporanPerkembangan::where('id', $id)->delete();

            return response()->json(['message' => 'Laporan perkembangan berhasil dihapus'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan saat menghapus laporan perkembangan'], 500);
        }
    }
}
