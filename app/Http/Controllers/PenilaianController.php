<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Event_Skema;
use App\Models\Nilai_Peserta;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenilaianController extends Controller
{
    public function index()
    {
        $event = Event::all();
        confirmDelete('Hapus Nilai Peserta', 'Apakah kamu yakin untuk menghapus?');
        return view('admin.penilaian.index', compact('event'));
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
        $totalNilaiQuery = DB::table('tb_nilai_peserta')
                    ->select('peserta_id', 
                        DB::raw('COUNT(nilai) as banyak_nilai'),
                        DB::raw('SUM(CASE WHEN nilai = 0 THEN 1 ELSE 0 END) as banyak_nilai_nol'),
                        DB::raw('SUM(nilai) as total_nilai'),
                        // DB::raw('ROUND(SUM(CASE WHEN nilai != 0 THEN nilai ELSE 0 END) / SUM(CASE WHEN nilai != 0 THEN 1 ELSE 0 END), 1) as avg_nilai')
                        DB::raw('SUM(CASE WHEN nilai != 0 THEN nilai ELSE 0 END) / SUM(CASE WHEN nilai != 0 THEN 1 ELSE 0 END) as avg_nilai')
                    )
                    ->groupBy('peserta_id');

        $data_skema = DB::table('tb_event_skema')
                    ->join('tb_event', 'tb_event_skema.event_id', '=', 'tb_event.id_event')
                    ->join('tb_skema', 'tb_event_skema.skema_id', '=', 'tb_skema.id_skema')

                    ->join('tb_tempat', 'tb_event.tempat_id', '=', 'tb_tempat.id_tempat')
                    ->join('tb_jenis_event', 'tb_event.jenis_event_id', '=', 'tb_jenis_event.id_jenis_event')
                    ->select('tb_event_skema.id_event_skema', 'tb_event.id_event', 'tb_event.nama_event',
                             'tb_event.tgl_mulai', 'tb_event.tgl_berakhir', 'tb_event.status', 
                             'tb_jenis_event.nama_jenis_event', 'tb_skema.nama_skema', 'tb_tempat.nama_tempat')
                    ->where('tb_event_skema.skema_id', $id)
                    ->get();

        $data_penguji = Event_Skema::where('id_event_skema', $data_skema->value('id_event_skema'))
            ->select('id_event_skema')
            ->with(
                ['event_skemaMenguji' => function($query) {
                    $query->select('id_user', 'nama_lengkap'); 
                }]
            )
            ->first();

        $data_sub_skema = DB::table('tb_event_skema')
                    ->join('tb_event', 'tb_event_skema.event_id', '=', 'tb_event.id_event')
                    ->join('tb_skema', 'tb_event_skema.skema_id', '=', 'tb_skema.id_skema')

                    ->join('tb_sub_skema', 'tb_skema.id_skema', '=', 'tb_sub_skema.skema_id')
                    ->select('tb_sub_skema.id_sub_skema', 'tb_sub_skema.judul_sub')
                    ->where('tb_event_skema.skema_id', $id)
                    ->get();

        $data_nilai_peserta = DB::table('tb_peserta')
                    ->join('tb_user', 'tb_peserta.user_id', '=', 'tb_user.id_user')
                    ->join('tb_event_skema', 'tb_peserta.event_skema_id', '=', 'tb_event_skema.id_event_skema')
                    ->join('tb_skema', 'tb_event_skema.skema_id', '=', 'tb_skema.id_skema')
                    ->leftJoinSub($totalNilaiQuery, 'nilai_stats', function($join) {
                        $join->on('tb_peserta.id_peserta', '=', 'nilai_stats.peserta_id');
                    })
                    ->select('tb_event_skema.id_event_skema', 'tb_user.id_user', 'tb_peserta.id_peserta', 
                        'tb_user.nama_lengkap', 'nilai_stats.banyak_nilai', 'nilai_stats.banyak_nilai_nol', 
                        'nilai_stats.total_nilai', 'nilai_stats.avg_nilai')
                    ->where('tb_peserta.event_skema_id', $data_skema->value('id_event_skema'))
                    ->orderBy('tb_user.id_user', 'asc')
                    ->get();

        $jumlahSubSkemaPerEvent = DB::table('tb_event_skema as es')
                    ->join('tb_skema as s', 'es.skema_id', '=', 's.id_skema')
                    ->join('tb_sub_skema as ss', 's.id_skema', '=', 'ss.skema_id')
                    ->select('es.id_event_skema', 's.nama_skema', 
                        DB::raw('COUNT(ss.id_sub_skema) as jumlah_sub_skema')
                    )
                    ->groupBy('es.id_event_skema', 's.nama_skema')
                    ->where('es.skema_id', $id)
                    ->get();

        return response()->json([
            'data_skema' => $data_skema, 
            'data_penguji' => $data_penguji, 
            'data_sub_skema' => $data_sub_skema, 
            'data_nilai_peserta' => $data_nilai_peserta,
            'jumlahSubSkemaPerEvent' => $jumlahSubSkemaPerEvent
        ]);
    }

    public function fetchPesertaData($id) 
    {
        $data_peserta = DB::table('tb_peserta')
                    ->join('tb_user', 'tb_peserta.user_id', '=', 'tb_user.id_user')
                    ->select('tb_peserta.id_peserta', 'tb_user.id_user', 'tb_user.nama_lengkap')
                    ->where('tb_peserta.id_peserta', $id)
                    ->get();

        return response()->json([
            'data_peserta' => $data_peserta
        ]);
    }

    public function create() // ==== EASTER EGG ====
    {
        return view('admin.penilaian.inputnilai');
    }

    public function storeNilaiData(Request $request)
    {
        $pesertaID = $request->pesertaID;
        $eventSkemaID = $request->event_skemaID;
        $nilaiSubSkema = $request->nilaiSubSkema;
        $created_by = $request->createdBy;

        DB::beginTransaction();

        try {
            foreach ($nilaiSubSkema as $subSkemaID => $nilai) {
                $nilaiExist = DB::table('tb_nilai_peserta')
                                ->where('peserta_id', $pesertaID)
                                ->where('sub_skema_id', $subSkemaID)
                                ->where('event_skema_id', $eventSkemaID)
                                ->first();

                if ($nilaiExist) {
                    // Jika nilai sudah ada, update
                    DB::table('tb_nilai_peserta')
                        ->where('peserta_id', $pesertaID)
                        ->where('sub_skema_id', $subSkemaID)
                        ->where('event_skema_id', $eventSkemaID)
                        ->update([
                            'nilai' => $nilai,
                            'updated_by' => $created_by,
                            'updated_at' => now()
                        ]);
                } else {
                    // Jika tidak ada, insert baru
                    DB::table('tb_nilai_peserta')->insert([
                        'peserta_id' => $pesertaID,
                        'sub_skema_id' => $subSkemaID,
                        'event_skema_id' => $eventSkemaID,
                        'nilai' => $nilai,
                        'created_by' => $created_by,
                        'created_at' => now()
                    ]);
                }
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Nilai berhasil disimpan']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => 'Gagal menyimpan nilai', 'error' => $e->getMessage()]);
        }
    }

    public function fetchNilaiData($id)
    {
        $data_nilai = DB::table('tb_nilai_peserta')
                ->join('tb_peserta', 'tb_nilai_peserta.peserta_id', '=', 'tb_peserta.id_peserta')
                ->join('tb_user', 'tb_peserta.user_id', '=', 'tb_user.id_user')
                ->join('tb_sub_skema', 'tb_nilai_peserta.sub_skema_id', '=', 'tb_sub_skema.id_sub_skema')
                ->select('tb_nilai_peserta.event_skema_id', 'tb_nilai_peserta.sub_skema_id', 'tb_sub_skema.judul_sub',
                        'tb_nilai_peserta.peserta_id', 'tb_user.nama_lengkap', 'tb_nilai_peserta.nilai')
                ->where('tb_nilai_peserta.peserta_id', $id)
                ->get();

        return response()->json([
            'data_nilai' => $data_nilai
        ]);
    }

    public function destroyNilaiData(Request $request)
    {
        $pesertaId = $request->pesertaId;

        try {
            Nilai_Peserta::where('peserta_id', $pesertaId)->delete();

            return response()->json(['message' => 'Nilai peserta berhasil dihapus'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan saat menghapus nilai peserta'], 500);
        }
    }

}
