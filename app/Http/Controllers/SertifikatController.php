<?php

namespace App\Http\Controllers;

use App\Models\Sertifikat;
use Carbon\Carbon;
use App\Models\User;

use App\Models\Event;
use App\Models\Peserta;
use App\Models\Event_Skema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SertifikatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $event = Event::all();
        confirmDelete('Hapus Nilai Peserta', 'Apakah kamu yakin untuk menghapus?');
        return view('admin.sertifikat.index', compact('event'));
    }

    public function fetchPesertaData1($id) 
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

        $data_peserta = DB::table('tb_peserta')
                    ->join('tb_user', 'tb_peserta.user_id', '=', 'tb_user.id_user')
                    ->join('tb_event_skema', 'tb_peserta.event_skema_id', '=', 'tb_event_skema.id_event_skema')
                    ->leftJoin('tb_sertifikat', 'tb_peserta.id_peserta', '=', 'tb_sertifikat.peserta_id')
                    ->select('tb_event_skema.id_event_skema',
                             'tb_peserta.id_peserta',
                             'tb_user.id_user', 'tb_user.nama_lengkap'
                            )
                    ->where('tb_event_skema.skema_id', $id)
                    ->where('tb_sertifikat.event_skema_id', $data_skema->id_event_skema)
                    ->get();

        return response()->json([
            'data_skema' => $data_skema,
            'data_peserta' => $data_peserta
        ]);
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
                    ->leftJoin('tb_sertifikat', function ($join) use ($eventSkemaID) {
                        $join->on('tb_sertifikat.peserta_id', '=', 'tb_peserta.id_peserta')
                                ->where('tb_sertifikat.event_skema_id', '=', $eventSkemaID);
                    })
                    ->where('tb_peserta.event_skema_id', $eventSkemaID)
                    ->whereNull('tb_sertifikat.id_sertifikat')
                    ->select('tb_peserta.id_peserta', 'tb_user.nama_lengkap')
                    ->get();

        $data_sertifikat = DB::table('tb_sertifikat')
                    ->join('tb_peserta', 'tb_sertifikat.peserta_id', '=', 'tb_peserta.id_peserta')
                    ->join('tb_user', 'tb_peserta.user_id', '=', 'tb_user.id_user')
                    ->select('tb_user.nama_lengkap',
                             'tb_sertifikat.nomor_sertifikat', 'tb_sertifikat.masa_berlaku',
                             'tb_sertifikat.tgl_terbit', 'tb_sertifikat.tgl_berakhir'
                    )
                    ->where('tb_sertifikat.event_skema_id', $eventSkemaID)
                    ->get();

        return response()->json([
            'data_skema' => $data_skema,
            'data_peserta' => $data_peserta,
            'data_sertifikat' => $data_sertifikat
        ]);
    }

    public function storeSertifikatData(Request $request)
    {
        // dd($request);
        $pesertaID = $request->pesertaID;
        $event_skemaID = $request->event_skemaID;
        $tgl_terbit = $request->tgl_terbit;
        $tgl_berakhir = $request->tgl_berakhir;
        $created_by = $request->createdBy;

        // Generate nomor sertifikat
        $dateTimeNow = Carbon::now()->format('YmdHis');
        $nomorSertifikat = "SRT-{$pesertaID}-{$event_skemaID}-{$dateTimeNow}";

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
                $masa_berlaku = $a->diffInYears($b);

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
                    'masa_berlaku' => $masa_berlaku,
                    'tgl_terbit' => $tgl_terbit,
                    'tgl_berakhir' => $tgl_berakhir,
                    'created_by' => $created_by,
                    'created_at' => now(),
                ]);
            }

            DB::commit();
            return response()->json(['message' => 'Sertifikat saved successfully'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
