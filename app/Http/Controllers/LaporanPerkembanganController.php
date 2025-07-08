<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Event;
use App\Models\Sub_Skema;
use App\Models\Event_Skema;
use Illuminate\Http\Request;
use App\Models\kemampuan_dasar;
use Illuminate\Support\Facades\DB;
use App\Models\LaporanPerkembangan;
use Illuminate\Support\Facades\Log;

class LaporanPerkembanganController extends Controller
{
    public function index()
    {
        $events = Event::where('status', 'Selesai')->get(); // Ganti nama variabel ke $events
        // $laporan = LaporanPerkembangan::all();
        $kemampuan = kemampuan_dasar::all();
        $Title = 'Laporan Perkembangan';
        confirmDelete('Hapus Laporan Perkembangan', 'Apakah kamu yakin untuk menghapus?');
        return view('admin.laporanperkembangan.index', compact('events', 'Title', 'kemampuan', )); // Kirim $events ke view
    }


    public function fetchEventData($id)
    {
        $data = DB::table('tb_event_skema')
            ->join('tb_skema', 'tb_event_skema.skema_id', '=', 'tb_skema.id_skema')
            ->select('tb_skema.id_skema', 'tb_skema.nama_skema')
            ->where('tb_event_skema.event_id', $id)
            ->get();

        return response()->json(['data' => $data]);
    }


    public function fetchSkemaData($id, $event_id)
{
    if (!$id) {
        return response()->json(['message' => 'ID tidak ditemukan'], 400);
    }

    // Ambil data skema
    $data_skema = Event_Skema::join('tb_event', 'tb_event_skema.event_id', '=', 'tb_event.id_event')
        ->join('tb_skema', 'tb_event_skema.skema_id', '=', 'tb_skema.id_skema')
        ->join('tb_tempat', 'tb_event.tempat_id', '=', 'tb_tempat.id_tempat')
        ->join('tb_jenis_event', 'tb_event.jenis_event_id', '=', 'tb_jenis_event.id_jenis_event')
        ->select(
            'tb_event_skema.id_event_skema',
            'tb_event.id_event',
            'tb_event.nama_event',
            'tb_event.tgl_mulai',
            'tb_event.tgl_berakhir',
            'tb_event.status',
            'tb_jenis_event.nama_jenis_event',
            'tb_skema.nama_skema',
            'tb_tempat.nama_tempat'
        )
        ->where('tb_event_skema.skema_id', $id)
        ->where('tb_event_skema.event_id', $event_id)
        ->first();

    // Ambil data penguji
    $data_penguji = Event_Skema::where('id_event_skema', $data_skema->id_event_skema)
        ->select('id_event_skema')
        ->with([
            'event_skemaMenguji' => function ($query) {
                $query->select('id_user', 'nama_lengkap');
            }
        ])
        ->first();

    // Ambil data sub skema
    $data_sub_skema = DB::table('tb_event_skema')
        ->join('tb_event', 'tb_event_skema.event_id', '=', 'tb_event.id_event')
        ->join('tb_skema', 'tb_event_skema.skema_id', '=', 'tb_skema.id_skema')
        ->join('tb_sub_skema', 'tb_skema.id_skema', '=', 'tb_sub_skema.skema_id')
        ->select('tb_event_skema.id_event_skema', 'tb_sub_skema.id_sub_skema', 'tb_sub_skema.judul_sub')
        ->where('tb_event_skema.skema_id', $id)
        ->get();

    // Ambil hanya id_event_skema dan id_peserta
    $data_peserta = DB::table('tb_peserta')
        ->join('tb_user', 'tb_peserta.user_id', '=', 'tb_user.id_user')
        ->join('tb_event_skema', 'tb_peserta.event_skema_id', '=', 'tb_event_skema.id_event_skema')
        ->leftJoin('tb_laporan_perkembangan', 'tb_peserta.id_peserta', '=', 'tb_laporan_perkembangan.peserta_id')
        ->select(
            'tb_peserta.id_peserta',
            'tb_user.nama_lengkap',
            'tb_event_skema.id_event_skema',
            'tb_laporan_perkembangan.catatan',
            'tb_laporan_perkembangan.tanggal_penilaian',
        )
        ->where('tb_peserta.event_skema_id', $data_skema->id_event_skema)
        ->get();

    // Ambil jumlah sub skema per event
    $jumlahSubSkemaPerEvent = DB::table('tb_event_skema')
        ->join('tb_skema', 'tb_event_skema.skema_id', '=', 'tb_skema.id_skema')
        ->join('tb_sub_skema', 'tb_skema.id_skema', '=', 'tb_sub_skema.skema_id')
        ->select(
            'tb_event_skema.id_event_skema',
            'tb_skema.nama_skema',
            DB::raw('COUNT(tb_sub_skema.id_sub_skema) as jumlah_sub_skema')
        )
        ->groupBy('tb_event_skema.id_event_skema', 'tb_skema.nama_skema')
        ->where('tb_event_skema.skema_id', $id)
        ->first();
// ✅ PERBAIKAN UTAMA: Tambahkan pengecekan null sebelum mengakses property
    if (!$data_skema) {
         return response()->json([
        'data_skema' => $data_skema,
        'data_penguji' => $data_penguji,
        'data_sub_skema' => $data_sub_skema,
        'data_peserta' => $data_peserta,
        'jumlahSubSkemaPerEvent' => $jumlahSubSkemaPerEvent
    ]);
    }
    return response()->json([
        'data_skema' => $data_skema,
        'data_penguji' => $data_penguji,
        'data_sub_skema' => $data_sub_skema,
        'data_peserta' => $data_peserta,
        'jumlahSubSkemaPerEvent' => $jumlahSubSkemaPerEvent
    ]);
}


    public function fetchPesertaData($id)
    {
        $data_peserta = DB::table('tb_peserta')
            ->join('tb_user', 'tb_peserta.user_id', '=', 'tb_user.id_user')
            ->select('tb_peserta.id_peserta', 'tb_user.id_user', 'tb_user.nama_lengkap', 'tb_peserta.event_skema_id')
            ->where('tb_peserta.id_peserta', $id)
            ->first();

        return response()->json([
            'data_peserta' => $data_peserta,

        ]);
    }

    public function fetchLaporanData($pesertaID)
    {
        $laporan = DB::table('tb_laporan_perkembangan')
            ->join('tb_peserta', 'tb_laporan_perkembangan.peserta_id', '=', 'tb_peserta.id_peserta')
            ->join('tb_user', 'tb_peserta.user_id', '=', 'tb_user.id_user')
            ->select(
                'tb_laporan_perkembangan.id_laporan_perkembangan',
                'tb_laporan_perkembangan.event_skema_id',
                // 'tb_laporan_perkembangan.sub_skema_id',
                'tb_laporan_perkembangan.peserta_id',
                'tb_laporan_perkembangan.tanggal_penilaian',
                'tb_laporan_perkembangan.catatan',
                'tb_laporan_perkembangan.pengalaman_anak',
                // 'tb_laporan_perkembangan.kemampuan_dasar',
                'tb_laporan_perkembangan.peralatan_penunjang',
                'tb_laporan_perkembangan.saran',
                'tb_user.nama_lengkap'
            )
            ->where('tb_laporan_perkembangan.peserta_id', $pesertaID)
            ->first();

        $kemampuan = DB::table('tb_kemampuan_dasar')
            ->where('laporan_perkembangan_id', $laporan->id_laporan_perkembangan)
            ->get();


        if ($laporan) {
            return response()->json([
                'data_laporan' => $laporan,
                'data_kemampuan_dasar' => $kemampuan,
            ]);
        } else {
            return response()->json([
                'message' => 'Laporan tidak ditemukan'
            ], 404);
        }

    }

    public function create()
    {
        return view('admin.laporanperkembangan.create');
    }

    public function storeNilaiData(Request $request, $id)
    {
        $validatedData = $request->validate([
            'event_skema_id' => 'required|integer',
            'pesertaID' => 'required|integer',
            'pengalaman_anak' => 'required|string',
            'kemampuan_dasar' => 'nullable|array',
            'peralatan_penunjang' => 'required|string',
            'saran' => 'required|string',
            'keterangan' => 'nullable|array',
            'keterangan.*' => 'in:kurang,cukup,baik,sangat baik',
            // 'catatan' => 'required|string',
        ]);

        DB::beginTransaction();

        try {
            $laporan = LaporanPerkembangan::create([
                'event_skema_id' => $validatedData['event_skema_id'],
                'peserta_id' => $validatedData['pesertaID'],
                'pengalaman_anak' => $validatedData['pengalaman_anak'],
                'peralatan_penunjang' => $validatedData['peralatan_penunjang'],
                'saran' => $validatedData['saran'],
                'tanggal_penilaian' => Carbon::now(),
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);

            if ($request->has('kemampuan_dasar') && $request->has('keterangan')) {
                foreach ($request->kemampuan_dasar as $index => $kemampuan) {
                    kemampuan_dasar::create([
                        'laporan_perkembangan_id' => $laporan->id_laporan_perkembangan,
                        'kemampuan' => $kemampuan,
                        'keterangan' => $request->keterangan[$index],
                    ]);
                }

                $counts = array_count_values($request->keterangan);
                $mostFrequentKeterangan = array_search(max($counts), $counts);

                $laporan->update(['catatan' => $mostFrequentKeterangan]);
            }

            DB::commit();
            // dd($request->all());
            return response()->json(['success' => true, 'message' => 'Laporan perkembangan berhasil disimpan']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => 'Gagal menyimpan laporan perkembangan', 'error' => $e->getMessage()]);
        }
    }

    public function update(Request $request, $pesertaID)
    {
        try {
            $request->validate([
                'pengalaman_anak' => 'required',
                'kemampuan_dasar' => 'nullable|array',
                'kemampuan_dasar.*.kemampuan_dasar' => 'required|string',
                'kemampuan_dasar.*.id' => 'required|exists:tb_kemampuan_dasar,id_kemampuan_dasar', // Validate IDs
                'peralatan_penunjang' => 'required',
                'saran' => 'required',
            ]);

            $laporan = LaporanPerkembangan::where('peserta_id', $pesertaID)->first();

            if (!$laporan) {
                return response()->json(['status' => 'error', 'message' => 'Data tidak ditemukan.'], 404);
            }

            $laporan->update([
                'pengalaman_anak' => $request->pengalaman_anak,
                'peralatan_penunjang' => $request->peralatan_penunjang,
                'saran' => $request->saran,
            ]);

            if (is_array($request->kemampuan_dasar)) {
                $count = [];
                foreach ($request->kemampuan_dasar as $item) {
                    // Assuming you want to update existing entries
                    $kemampuan = Kemampuan_dasar::find($item['id']);
                    if ($kemampuan) {
                        $kemampuan->update([
                            'kemampuan' => $item['kemampuan_dasar'],
                            'keterangan' => $item['keterangan'],
                        ]);

                        if (isset($item['keterangan'])) {
                            $counts[] = $item['keterangan'];
                        }
                    }
                }
                if (!empty($counts)) {
                    $mostFrequentKeterangan = array_count_values($counts);
                    $mostFrequentKeterangan = array_search(max($mostFrequentKeterangan), $mostFrequentKeterangan);

                    $laporan->update(['catatan' => $mostFrequentKeterangan]);
                }
            }

            Log::info($request->all());

            return response()->json([
                'status' => 'success',
                'message' => 'Laporan berhasil diupdate'
            ]);
        } catch (\Exception $e) {
            Log::error('Kesalahan saat mengupdate laporan: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }


    public function destroyLaporanData(Request $request, $pesertaID)
    {
        Log::info('Menghapus data dengan pesertaID: ' . $pesertaID);

        try {
            // Memeriksa data sebelum menghapus
            $laporan = LaporanPerkembangan::where('peserta_id', $pesertaID)->first();
            if (!$laporan) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }

            $deletedRows = $laporan->delete(); // Memanggil metode delete pada model

            if ($deletedRows) {
                return response()->json(['message' => 'Laporan perkembangan berhasil dihapus'], 200);
            } else {
                return response()->json(['message' => 'Gagal menghapus data'], 500);
            }
        } catch (\Exception $e) {
            Log::error('Kesalahan saat menghapus laporan: ' . $e->getMessage());
            return response()->json(['message' => 'Terjadi kesalahan saat menghapus laporan perkembangan: ' . $e->getMessage()], 500);
        }
    }

}
