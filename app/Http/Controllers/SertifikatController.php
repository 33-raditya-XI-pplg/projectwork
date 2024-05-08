<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\User;

use App\Models\Event;
use App\Models\Peserta;

use App\Models\Background;
use App\Models\Sertifikat;
use App\Models\Event_Skema;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SertifikatController extends Controller
{
    public function index()
    {
        $event = Event::all();
        confirmDelete('Hapus Nilai Peserta', 'Apakah kamu yakin untuk menghapus?');
        return view('admin.sertifikat.index', compact('event'));
    }

    public function fetchPesertaData($id)
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

        $eventSkemaID = $data_skema->id_event_skema;
        $data_peserta = DB::table('tb_peserta')
                    ->join('tb_user', 'tb_user.id_user', '=', 'tb_peserta.user_id')
                    ->leftJoinSub(function ($query) {
                        $query->from('tb_nilai_peserta')
                            ->select('peserta_id',
                                DB::raw('COUNT(nilai) as banyak_nilai'),
                                DB::raw('SUM(CASE WHEN nilai = 0 THEN 1 ELSE 0 END) as banyak_nilai_nol'),
                            )
                            ->groupBy('peserta_id');
                    }, 'nilai_stats', function ($join) {
                        $join->on('tb_peserta.id_peserta', '=', 'nilai_stats.peserta_id');
                    })
                    ->leftJoin('tb_sertifikat', function ($join) use ($eventSkemaID) {
                        $join->on('tb_sertifikat.peserta_id', '=', 'tb_peserta.id_peserta')
                                ->where('tb_sertifikat.event_skema_id', '=', $eventSkemaID);
                    })
                    ->whereNot('nilai_stats.banyak_nilai', 0)
                    ->where('tb_peserta.event_skema_id', $eventSkemaID)
                    ->whereNull('tb_sertifikat.id_sertifikat')
                    ->select('tb_peserta.id_peserta', 'tb_user.nama_lengkap')
                    ->get();

        $data_sertifikat = DB::table('tb_sertifikat')
                    ->join('tb_peserta', 'tb_sertifikat.peserta_id', '=', 'tb_peserta.id_peserta')
                    ->join('tb_user', 'tb_peserta.user_id', '=', 'tb_user.id_user')
                    ->select('tb_peserta.id_peserta',
                             'tb_user.nama_lengkap',
                             'tb_sertifikat.nomor_sertifikat', 'tb_sertifikat.masa_berlaku',
                             'tb_sertifikat.tgl_terbit', 'tb_sertifikat.tgl_berakhir'
                    )
                    ->where('tb_sertifikat.event_skema_id', $eventSkemaID)
                    ->get();

        $total_peserta = DB::table('tb_peserta')
                    ->where('event_skema_id', $eventSkemaID)
                    ->count();

        $data_peserta_tanpa_nilai = DB::table('tb_peserta') // Namun memiliki nilai
                    ->leftJoin('tb_nilai_peserta', 'tb_nilai_peserta.peserta_id', '=', 'tb_peserta.id_peserta')
                    ->where('tb_peserta.event_skema_id', $eventSkemaID)
                    ->whereNull('tb_nilai_peserta.nilai') // Pastikan nilai sudah ada
                    ->select('tb_peserta.id_peserta')
                    ->get();

        $data_peserta_tanpa_sertifikat = DB::table('tb_peserta') // Namun memiliki nilai
                    ->join('tb_nilai_peserta', 'tb_nilai_peserta.peserta_id', '=', 'tb_peserta.id_peserta')
                    ->leftJoin('tb_sertifikat', function($join) use ($eventSkemaID) {
                        $join->on('tb_sertifikat.peserta_id', '=', 'tb_peserta.id_peserta')
                            ->where('tb_sertifikat.event_skema_id', '=', $eventSkemaID);
                    })
                    ->where('tb_peserta.event_skema_id', $eventSkemaID)
                    ->whereNotNull('tb_nilai_peserta.nilai') // Pastikan nilai sudah ada
                    ->whereNull('tb_sertifikat.id_sertifikat') // Sertifikat tidak ada
                    ->groupBy('tb_peserta.id_peserta') // Mengelompokkan berdasarkan id_peserta
                    ->select('tb_peserta.id_peserta')
                    ->get();

        return response()->json([
            'data_skema' => $data_skema,
            'data_peserta' => $data_peserta,
            'data_sertifikat' => $data_sertifikat,
            'total_peserta' => $total_peserta,
            'data_peserta_tanpa_nilai' => $data_peserta_tanpa_nilai,
            'data_peserta_tanpa_sertifikat' => $data_peserta_tanpa_sertifikat
        ]);
    }    

    public function storeSertifikatData(Request $request)
    {
        // dd($request);
        $pesertaID = $request->pesertaID;
        $tgl_terbit = $request->tgl_terbit;
        $tgl_berakhir = $request->tgl_berakhir;
        $event_skemaID = $request->event_skemaID;
        $created_by = $request->created_by;

        // Generate nomor sertifikat
        $dateTimeNow = Carbon::now()->format('YmdHis');
        $nomorSertifikat = "SRT-{$event_skemaID}-{$pesertaID}-{$dateTimeNow}";

        try {
            DB::beginTransaction();

            // Cek jika sudah ada sertifikat untuk peserta dan event tersebut
            $sertifikat = DB::table('tb_sertifikat')
                    ->where('peserta_id', $pesertaID)
                    ->where('event_skema_id', $event_skemaID)
                    ->first();
            
            if ($sertifikat) {
                // Ubah tanggal terbit dan tanggal berakhir menjadi objek Carbon
                $a = Carbon::parse($tgl_terbit);
                $b = Carbon::parse($tgl_berakhir);
                
                // Hitung masa berlaku dalam tahun
                $masa_berlaku_diff = $a->diffInYears($b);
                if ($masa_berlaku_diff == 0) {
                    $masa_berlaku_diff = $a->diffInMonths($b);
                    $masa_berlaku = $masa_berlaku_diff . ' Bulan';
                } else {
                    $masa_berlaku = $masa_berlaku_diff . ' Tahun';
                }

                // Update sertifikat yang sudah ada
                DB::table('tb_sertifikat')
                  ->where('id_sertifikat', $sertifikat->id_sertifikat)
                  ->update([
                      'nomor_sertifikat' => $nomorSertifikat,
                      'masa_berlaku' => $masa_berlaku,
                      'tgl_terbit' => $tgl_terbit,
                      'tgl_berakhir' => $tgl_berakhir,
                      'updated_by' => $created_by,
                      'updated_at' => now(),
                  ]);
            } else {
                $nilai_peserta = DB::table('tb_nilai_peserta')
                                ->select(
                                    DB::raw('COUNT(nilai) as banyak_nilai'),
                                    DB::raw('SUM(CASE WHEN nilai = 0 THEN 1 ELSE 0 END) as banyak_nilai_nol'),
                                    DB::raw('SUM(nilai) as total_nilai'),
                                    DB::raw('SUM(CASE WHEN nilai != 0 THEN nilai ELSE 0 END) / SUM(CASE WHEN nilai != 0 THEN 1 ELSE 0 END) as avg_nilai')
                                )
                                ->where('peserta_id', $pesertaID)
                                ->where('event_skema_id', $event_skemaID)
                                ->first();

                $keterangan_nilai_peserta = DB::table('tb_event_skema_rentang_nilai as tb_es_rn')
                                ->join('tb_rentang_nilai', 'tb_es_rn.rentang_nilai_id', '=', 'tb_rentang_nilai.id_rentang_nilai')
                                ->join('tb_event_skema', 'tb_es_rn.event_skema_id', '=', 'tb_event_skema.id_event_skema')
                                ->select('tb_rentang_nilai.nama_konversi_nilai', 'tb_rentang_nilai.inisial_rentang_nilai', 'tb_rentang_nilai.keterangan')
                                ->where('tb_es_rn.event_skema_id', $event_skemaID)
                                ->where('rentang_bawah', '<=', $nilai_peserta->avg_nilai)
                                ->where('rentang_atas', '>=', $nilai_peserta->avg_nilai)
                                ->first();

                // Ubah tanggal terbit dan tanggal berakhir menjadi objek Carbon
                $a = Carbon::parse($tgl_terbit);
                $b = Carbon::parse($tgl_berakhir);
                
                // Hitung masa berlaku dalam tahun
                $masa_berlaku_diff = $a->diffInYears($b);
                if ($masa_berlaku_diff == 0) {
                    $masa_berlaku_diff = $a->diffInMonths($b);
                    $masa_berlaku = $masa_berlaku_diff . ' Bulan';
                } else {
                    $masa_berlaku = $masa_berlaku_diff . ' Tahun';
                }
                // dd($masa_berlaku);

                // Buat sertifikat baru
                DB::table('tb_sertifikat')->insert([
                    'peserta_id' => $pesertaID,
                    'event_skema_id' => $event_skemaID,
                    'nomor_sertifikat' => $nomorSertifikat,
                    'nilai' => $nilai_peserta->avg_nilai,
                    'keterangan' => $keterangan_nilai_peserta->keterangan,
                    'inisial_nilai' => $keterangan_nilai_peserta->inisial_rentang_nilai,
                    'tgl_terbit' => $tgl_terbit,
                    'tgl_berakhir' => $tgl_berakhir,
                    'masa_berlaku' => $masa_berlaku,
                    'created_by' => $created_by,
                    'created_at' => now(),
                ]);
            }

            DB::commit();
            return response()->json(['message' => 'Sertifikat saved successfully'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'asu', $e->getMessage()], 500);
        }
    }

    public function fetchSertifikatData($id)
    {
        $data_sertifikat_peserta = DB::table('tb_sertifikat')
                ->join('tb_peserta', 'tb_sertifikat.peserta_id', '=', 'tb_peserta.id_peserta')
                ->join('tb_user', 'tb_peserta.user_id', '=', 'tb_user.id_user')
                ->join('tb_event_skema', 'tb_peserta.event_skema_id', '=', 'tb_event_skema.id_event_skema')
                ->join('tb_skema', 'tb_event_skema.skema_id', '=', 'tb_skema.id_skema')
                ->select('tb_user.nama_lengkap',
                         'tb_skema.nama_skema',
                         'tb_sertifikat.tgl_terbit', 'tb_sertifikat.tgl_berakhir'
                )
                ->where('tb_sertifikat.peserta_id', $id)
                ->first();

        return response()->json([
            'data_sertifikat_peserta' => $data_sertifikat_peserta
        ]);
    }

    public function destroySertifikatData(Request $request)
    {
        $pesertaID = $request->pesertaID;

        try {
            Sertifikat::where('peserta_id', $pesertaID)->delete();

            return response()->json(['message' => 'Nilai peserta berhasil dihapus'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan saat menghapus nilai peserta'], 500);
        }
    }

    public function cetakSertifikat11(Request $request) { // Pake ini wir
        $pesertaID = 1;
        $event_skemaID = 1;
    
        $data_sertifikat_peserta = DB::table('tb_sertifikat')
                        ->select('id_sertifikat', 'peserta_id', 'event_skema_id', 
                                 'nomor_sertifikat', 'tgl_terbit', 'keterangan'
                        )
                        ->where('peserta_id', $pesertaID)
                        ->first();
    
        $fileName = 'Cetak-Sertif-' . $data_sertifikat_peserta->nomor_sertifikat . '.pdf';
        $templateBg = public_path('assets/img/dummy/bg/template_piagam_1.png');
        
        $pdf = PDF::loadView('sertifikat_1', compact('data_sertifikat_peserta', 'templateBg'));
        $pdf->setPaper('a4', 'portrait'); // Corrected spelling of 'portrait'

        return $pdf->download($fileName);

    }

    public function cetakSertifikat(Request $request) {
        $pesertaID = $request->input('selected_ids');
        $event_skemaID = $request->event_skemaID;

        $data_sertifikat_peserta = DB::table('tb_sertifikat')
                        ->select('id_sertifikat', 'peserta_id', 'event_skema_id', 
                                 'nomor_sertifikat', 'tgl_terbit', 'keterangan'
                        )
                        ->whereIn('peserta_id', $pesertaID)
                        ->first();
    
        $fileName = 'Cetak-Sertif-' . $data_sertifikat_peserta->nomor_sertifikat . '.pdf';
        $templateBg = public_path('assets/img/dummy/bg/template_piagam_1.png');
        
        $pdf = PDF::loadView('sertifikat_1', compact('data_sertifikat_peserta', 'templateBg'));
        $pdf->setPaper('a4', 'portrait'); // Corrected spelling of 'portrait'

        return $pdf->download($fileName);

    }

    public function cetakSertifikat2(Request $request)
    {
        $pesertaID = $request->pesertaID;
        $event_skemaID = $request->event_skemaID;

    // public function cetakSertifikat()
    // {
    //     $pesertaID = 1;
    //     $event_skemaID = 1;

        $data_sertifikat_peserta = DB::table('tb_sertifikat')
                        ->join('tb_peserta', 'tb_sertifikat.peserta_id', '=', 'tb_peserta.id_peserta')
                        ->join('tb_user', 'tb_peserta.user_id', '=', 'tb_user.id_user')
                        ->join('tb_event_skema', 'tb_peserta.event_skema_id', '=', 'tb_event_skema.id_event_skema')
                        ->join('tb_event', 'tb_event_skema.event_id', '=', 'tb_event.id_event')
                        ->join('tb_jenis_event', 'tb_event.jenis_event_id', '=', 'tb_jenis_event.id_jenis_event')
                        ->join('tb_skema', 'tb_event_skema.skema_id', '=', 'tb_skema.id_skema')
                        ->join('tb_background', 'tb_event_skema.background_id', '=', 'tb_background.id_background')
                        ->select('tb_user.nama_lengkap',
                                 'tb_event.nama_event', 'tb_jenis_event.nama_jenis_event', 'tb_skema.nama_skema',
                                 'tb_background.nama_bg', 'tb_background.orientasi_bg', 'tb_background.path_bg',
                                 'tb_sertifikat.nomor_sertifikat', 
                                 'tb_sertifikat.tgl_terbit', 'tb_sertifikat.tgl_berakhir', 'tb_sertifikat.masa_berlaku',
                                 'tb_sertifikat.nilai', 'tb_sertifikat.keterangan' 
                        )
                        ->where('tb_sertifikat.peserta_id', $pesertaID)
                        ->first();
                        // dd($data_sertifikat_peserta);

        $data_penadatangan = DB::table('tb_event_skema')
                        ->join('tb_penandatangan', 'tb_event_skema.id_event_skema', '=', 'tb_penandatangan.event_skema_id')
                        ->join('tb_ttd', 'tb_penandatangan.ttd_id', '=', 'tb_ttd.id_ttd')
                        ->select('tb_ttd.nama_ttd', 'tb_ttd.jabatan', 'tb_ttd.path_ttd')
                        ->where('tb_penandatangan.event_skema_id', $event_skemaID)
                        ->get();

        $templateBg = storage_path($data_sertifikat_peserta->path_bg);
        $fileName = 'Cetak-Sertif-' . $data_sertifikat_peserta->nomor_sertifikat . '.pdf';
        
        $pdf = PDF::loadView('yourtemplate', 
            compact('templateBg', 
                    'data_sertifikat_peserta', 'data_penadatangan'
            )
        
        );
        $pdf->setPaper('a4', 'potrait');

        return $pdf->download($fileName);

        // return view('yourTemplate', compact('data_sertifikat_peserta', 'data_penadatangan'));

        // return response()->json([
        //     'data_sertifikat_peserta' => $data_sertifikat_peserta,
        //     'data_penadatangan' => $data_penadatangan
        // ]);
    }

    public function cetakSertifikat1(Request $request)
    {
        $pesertaID = 1;
        $event_skemaID = 1;

        $data_sertifikat_peserta = DB::table('tb_sertifikat')
                        ->join('tb_peserta', 'tb_sertifikat.peserta_id', '=', 'tb_peserta.id_peserta')
                        ->join('tb_user', 'tb_peserta.user_id', '=', 'tb_user.id_user')
                        ->join('tb_event_skema', 'tb_peserta.event_skema_id', '=', 'tb_event_skema.id_event_skema')
                        ->join('tb_event', 'tb_event_skema.event_id', '=', 'tb_event.id_event')
                        ->join('tb_jenis_event', 'tb_event.jenis_event_id', '=', 'tb_jenis_event.id_jenis_event')
                        ->join('tb_skema', 'tb_event_skema.skema_id', '=', 'tb_skema.id_skema')
                        ->join('tb_background', 'tb_event_skema.background_id', '=', 'tb_background.id_background')
                        ->select('tb_user.nama_lengkap',
                                 'tb_event.nama_event', 'tb_jenis_event.nama_jenis_event', 'tb_skema.nama_skema',
                                 'tb_background.nama_bg', 'tb_background.orientasi_bg', 'tb_background.path_bg',
                                 'tb_sertifikat.nomor_sertifikat', 
                                 'tb_sertifikat.tgl_terbit', 'tb_sertifikat.tgl_berakhir', 'tb_sertifikat.masa_berlaku',
                                 'tb_sertifikat.nilai', 'tb_sertifikat.keterangan' 
                        )
                        ->where('tb_sertifikat.peserta_id', $pesertaID)
                        ->first();

        $data_penadatangan = DB::table('tb_event_skema')
                        ->join('tb_penandatangan', 'tb_event_skema.id_event_skema', '=', 'tb_penandatangan.event_skema_id')
                        ->join('tb_ttd', 'tb_penandatangan.ttd_id', '=', 'tb_ttd.id_ttd')
                        ->select('tb_ttd.nama_ttd', 'tb_ttd.jabatan', 'tb_ttd.path_ttd')
                        ->where('tb_penandatangan.event_skema_id', $event_skemaID)
                        ->get();

        $fileName = 'Cetak-Sertif-' . $data_sertifikat_peserta->nomor_sertifikat . '.pdf';
        $templateBg = $data_sertifikat_peserta->path_bg;
        // $templateBg = public_path('assets/img/dummy/bg/template_piagam_2.png');
    
        // if (!$data_sertifikat_peserta) {
        //     return response()->json([
        //         'status' => 'error',
        //         'message' => 'Data sertifikat tidak ditemukan'
        //     ], 404);
        // }
    
        try {
            $pdf = PDF::loadView('sertifikat_3', compact('data_sertifikat_peserta', 'templateBg'));
            $pdf->setPaper('a4', 'portrait'); // Corrected spelling of 'portrait'
    
            // PDF generated successfully, return a JSON response
            return response()->json([
                'status' => 'success',
                'message' => 'PDF successfully generated',
                'file_url' => $pdf->download($fileName) // This will stream the PDF back to the client
            ], 200);
        } catch (\Exception $e) {
            // Handle exception if PDF generation fails
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to generate PDF: ' . $e->getMessage()
            ], 500);
        }
    }

    public function exportPDF()
    {
        $pdf = PDF::loadview('yourtemplate')->setPaper('A4', 'portrait');
        return $pdf->download('coba.pdf');
    }

    public function exportToPDF(Request $request) { 
        $ids = $request->input('selected_ids');
        $event_skemaID = $request->input('event_skema_id');

        $data_sertifikat_peserta = DB::table('tb_sertifikat')
                        ->join('tb_peserta', 'tb_sertifikat.peserta_id', '=', 'tb_peserta.id_peserta')
                        ->join('tb_user', 'tb_peserta.user_id', '=', 'tb_user.id_user')
                        ->join('tb_event_skema', 'tb_peserta.event_skema_id', '=', 'tb_event_skema.id_event_skema')
                        ->join('tb_event', 'tb_event_skema.event_id', '=', 'tb_event.id_event')
                        ->join('tb_jenis_event', 'tb_event.jenis_event_id', '=', 'tb_jenis_event.id_jenis_event')
                        ->join('tb_skema', 'tb_event_skema.skema_id', '=', 'tb_skema.id_skema')
                        ->join('tb_background', 'tb_event_skema.background_id', '=', 'tb_background.id_background')
                        ->select('tb_user.nama_lengkap',
                                 'tb_event.nama_event', 'tb_jenis_event.nama_jenis_event', 'tb_skema.nama_skema',
                                 'tb_background.nama_bg', 'tb_background.orientasi_bg', 'tb_background.path_bg',
                                 'tb_sertifikat.nomor_sertifikat', 
                                 'tb_sertifikat.tgl_terbit', 'tb_sertifikat.tgl_berakhir', 'tb_sertifikat.masa_berlaku',
                                 'tb_sertifikat.nilai', 'tb_sertifikat.keterangan' 
                        )
                        ->whereIn('tb_sertifikat.peserta_id', $ids)
                        ->get();

        $data_penadatangan = DB::table('tb_event_skema')
                        ->join('tb_penandatangan', 'tb_event_skema.id_event_skema', '=', 'tb_penandatangan.event_skema_id')
                        ->join('tb_ttd', 'tb_penandatangan.ttd_id', '=', 'tb_ttd.id_ttd')
                        ->select('tb_ttd.nama_ttd', 'tb_ttd.jabatan', 'tb_ttd.path_ttd')
                        ->where('tb_penandatangan.event_skema_id', $event_skemaID)
                        ->get();

        $templateBg = public_path($data_sertifikat_peserta[0]->path_bg);
        
        $fileName = "";
        count($ids) != 1 ?
            $fileName = 'Sertif-' . count($ids) . '-Orang-Peserta.pdf' :
            $fileName = 'Sertif-' . $data_sertifikat_peserta[0]->nomor_sertifikat . '.pdf';

        $pdf = "";
        if ($data_sertifikat_peserta[0]->orientasi_bg != 'landscape') {
            $pdf = PDF::loadView('sertifikat_potrait', 
                compact('data_sertifikat_peserta', 'data_penadatangan', 'templateBg')
            )->setPaper('a4', 'potrait');
        } else {
            $pdf = PDF::loadView('sertifikat_landscape', 
                compact('data_sertifikat_peserta', 'data_penadatangan', 'templateBg')
            )->setPaper('a4', 'landscape');
        }

        return $pdf->download($fileName);
    }
}
