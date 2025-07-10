<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Event;
use App\Models\Sertifikat;
use App\Models\Event_Skema;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class SertifikatController extends Controller
{
    public function index()
    {
        $event = Event::where('status', 'Selesai')->get();
        $Title = 'Sertifikat';
        confirmDelete('Hapus Nilai Peserta', 'Apakah kamu yakin untuk menghapus?');
        return view('admin.sertifikat.index', compact('event', 'Title'));
    }

    public function fetchPesertaData($id, $event_id)
    {
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

        $eventSkemaID = $data_skema->id_event_skema;
        $data_peserta = DB::table('tb_peserta')
            ->join('tb_user', 'tb_user.id_user', '=', 'tb_peserta.user_id')
            ->leftJoinSub(function ($query) {
                $query->from('tb_nilai_peserta')
                    ->select(
                        'peserta_id',
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
            ->select(
                'tb_peserta.id_peserta',
                'tb_user.nama_lengkap',
                'tb_sertifikat.nomor_sertifikat',
                'tb_sertifikat.masa_berlaku',
                'tb_sertifikat.tgl_terbit',
                'tb_sertifikat.tgl_berakhir'
            )
            ->where('tb_sertifikat.event_skema_id', $eventSkemaID)
            ->get();

        $total_peserta = DB::table('tb_peserta')
            ->where('event_skema_id', $eventSkemaID)
            ->count();

        $data_peserta_tanpa_nilai = DB::table('tb_peserta')
            ->leftJoin('tb_nilai_peserta', 'tb_nilai_peserta.peserta_id', '=', 'tb_peserta.id_peserta')
            ->where('tb_peserta.event_skema_id', $eventSkemaID)
            ->whereNull('tb_nilai_peserta.nilai')
            ->select('tb_peserta.id_peserta')
            ->get();

        $data_peserta_tanpa_sertifikat = DB::table('tb_peserta')
            ->join('tb_nilai_peserta', 'tb_nilai_peserta.peserta_id', '=', 'tb_peserta.id_peserta')
            ->leftJoin('tb_sertifikat', function ($join) use ($eventSkemaID) {
                $join->on('tb_sertifikat.peserta_id', '=', 'tb_peserta.id_peserta')
                    ->where('tb_sertifikat.event_skema_id', '=', $eventSkemaID);
            })
            ->where('tb_peserta.event_skema_id', $eventSkemaID)
            ->whereNotNull('tb_nilai_peserta.nilai')
            ->whereNull('tb_sertifikat.id_sertifikat')
            ->groupBy('tb_peserta.id_peserta')
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

    public function generateNomorSertifikat($tglTerbitInput)
    {
        $tglTerbit = Carbon::parse($tglTerbitInput);
        $bulan = $tglTerbit->format('n');
        $tahun = $tglTerbit->format('Y');

        $count = Sertifikat::whereYear('tgl_terbit', $tahun)
            ->whereMonth('tgl_terbit', $bulan)
            ->count();

        $autoIncrement = str_pad($count + 1, 3, '0', STR_PAD_LEFT);
        $bulanRomawi = $this->convertToRoman($bulan);

        $nomorSertifikat = "{$autoIncrement}/MASCITRA/SKOM/{$bulanRomawi}/{$tahun}";

        return $nomorSertifikat;
    }

    private function convertToRoman($month)
    {
        $map = [
            1 => 'I',
            2 => 'II',
            3 => 'III',
            4 => 'IV',
            5 => 'V',
            6 => 'VI',
            7 => 'VII',
            8 => 'VIII',
            9 => 'IX',
            10 => 'X',
            11 => 'XI',
            12 => 'XII'
        ];

        return $map[$month];
    }

    public function storeSertifikatData(Request $request)
    {
        $option = $request->option;
        $tgl_terbit = $request->tgl_terbit;
        $tgl_berakhir = $request->tgl_berakhir ?? null;
        $event_skemaID = $request->event_skemaID;
        $created_by = $request->created_by;


        // dd($request);

        // dd($request);
        try {
            DB::beginTransaction();

            if (!empty($request->option)) {
                if ($option == 'all') {
                    $pesertas = db::table('tb_peserta')
                        ->where('event_skema_id', $event_skemaID)
                        ->select('id_peserta')
                        ->get();

                    foreach ($pesertas as $row) {
                        $pesertaID = $row->id_peserta;
                        $exist = Sertifikat::where('peserta_id', $pesertaID)->exists();

                        // Buat sertifikat baru
                        if (!$exist) {
                            // Generate nomor sertifikat
                            $nomorSertifikat = $this->generateNomorSertifikat($tgl_terbit);

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
                                ->select('tb_rentang_nilai.nama_konversi_nilai', 'tb_rentang_nilai.inisial_rentang_nilai', 'tb_rentang_nilai.keterangan_rentang_nilai')
                                ->where('tb_es_rn.event_skema_id', $event_skemaID)
                                ->where('rentang_bawah', '<=', $nilai_peserta->avg_nilai)
                                ->where('rentang_atas', '>=', $nilai_peserta->avg_nilai)
                                ->first();


                            if (empty($tgl_berakhir)) {
                                $masa_berlaku = '-';
                            } else {
                                $a = Carbon::parse($tgl_terbit);
                                $b = Carbon::parse($tgl_berakhir);
                                // Hitung masa berlaku dalam tahun
                                $masa_berlaku_diff = $a->diffInYears($b);
                                if ($masa_berlaku_diff == 0) {
                                    $masa_berlaku_diff = $a->diffInMonths($b);
                                    if ($masa_berlaku_diff == 0) {
                                        $masa_berlaku_diff = $a->diffInDays($b);
                                        $masa_berlaku = $masa_berlaku_diff . ' Hari';
                                    } else {
                                        $masa_berlaku = $masa_berlaku_diff . ' Bulan';
                                    }
                                } else {
                                    $masa_berlaku = $masa_berlaku_diff . ' Tahun';
                                }
                            }

                            Sertifikat::create([
                                'peserta_id' => $pesertaID,
                                'event_skema_id' => $event_skemaID,
                                'nomor_sertifikat' => $nomorSertifikat,
                                'nilai' => $nilai_peserta->avg_nilai,
                                'keterangan' => $keterangan_nilai_peserta->keterangan_rentang_nilai,
                                'inisial_nilai' => $keterangan_nilai_peserta->inisial_rentang_nilai,
                                'tgl_terbit' => $tgl_terbit,
                                'tgl_berakhir' => $tgl_berakhir,
                                'masa_berlaku' => $masa_berlaku,
                                'created_by' => $created_by,
                                'created_at' => now(),
                            ]);
                        }
                    }

                }
            }

            DB::commit();
            return response()->json(['message' => 'Sertifikat saved successfully'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'asu', $e->getMessage()], 500);
        }
    }


    public function updateSertifikatData(Request $request) // Bakal e jadi edit function
    {
        $pesertaID = $request->pesertaID;
        $tgl_terbit = $request->tgl_terbit;
        $tgl_berakhir = $request->tgl_berakhir;
        $event_skemaID = $request->event_skemaID;
        $created_by = $request->created_by;

        // Generate nomor sertifikat
        $nomorSertifikat = $this->generateNomorSertifikat($tgl_terbit);

        try {
            DB::beginTransaction();

            // Cek jika sudah ada sertifikat untuk peserta dan event tersebut
            $sertifikat = DB::table('tb_sertifikat')
                ->where('peserta_id', $pesertaID)
                ->where('event_skema_id', $event_skemaID)
                ->first();

            if ($sertifikat) {

                if (empty($tgl_berakhir)) {
                    $masa_berlaku = '-';
                } else {
                    $a = Carbon::parse($tgl_terbit);
                    $b = Carbon::parse($tgl_berakhir);
                    // Hitung masa berlaku dalam tahun
                    $masa_berlaku_diff = $a->diffInYears($b);
                    if ($masa_berlaku_diff == 0) {
                        $masa_berlaku_diff = $a->diffInMonths($b);
                        if ($masa_berlaku_diff == 0) {
                            $masa_berlaku_diff = $a->diffInDays($b);
                            $masa_berlaku = $masa_berlaku_diff . ' Hari';
                        } else {
                            $masa_berlaku = $masa_berlaku_diff . ' Bulan';
                        }
                    } else {
                        $masa_berlaku = $masa_berlaku_diff . ' Tahun';
                    }
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
                    ->select('tb_rentang_nilai.nama_konversi_nilai', 'tb_rentang_nilai.inisial_rentang_nilai', 'tb_rentang_nilai.keterangan_rentang_nilai')
                    ->where('tb_es_rn.event_skema_id', $event_skemaID)
                    ->where('rentang_bawah', '<=', $nilai_peserta->avg_nilai)
                    ->where('rentang_atas', '>=', $nilai_peserta->avg_nilai)
                    ->first();


                if (empty($tgl_berakhir)) {
                    $masa_berlaku = '-';
                } else {
                    $a = Carbon::parse($tgl_terbit);
                    $b = Carbon::parse($tgl_berakhir);
                    // Hitung masa berlaku dalam tahun
                    $masa_berlaku_diff = $a->diffInYears($b);
                    if ($masa_berlaku_diff == 0) {
                        $masa_berlaku_diff = $a->diffInMonths($b);
                        if ($masa_berlaku_diff == 0) {
                            $masa_berlaku_diff = $a->diffInDays($b);
                            $masa_berlaku = $masa_berlaku_diff . ' Hari';
                        } else {
                            $masa_berlaku = $masa_berlaku_diff . ' Bulan';
                        }
                    } else {
                        $masa_berlaku = $masa_berlaku_diff . ' Tahun';
                    }
                }

                // Buat sertifikat baru
                DB::table('tb_sertifikat')->insert([
                    'peserta_id' => $pesertaID,
                    'event_skema_id' => $event_skemaID,
                    'nomor_sertifikat' => $nomorSertifikat,
                    'nilai' => $nilai_peserta->avg_nilai,
                    'keterangan' => $keterangan_nilai_peserta->keterangan_rentang_nilai,
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
            ->select(
                'tb_user.nama_lengkap',
                'tb_skema.nama_skema',
                'tb_sertifikat.tgl_terbit',
                'tb_sertifikat.tgl_berakhir'
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

    public function exportToPDF(Request $request)
    {
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
            ->select(
                'tb_user.nama_lengkap',
                'tb_event.nama_event',
                'tb_jenis_event.nama_jenis_event',
                'tb_skema.nama_skema',
                'tb_background.nama_bg',
                'tb_background.orientasi_bg',
                'tb_background.path_bg',
                'tb_sertifikat.nomor_sertifikat',
                'tb_sertifikat.tgl_terbit',
                'tb_sertifikat.tgl_berakhir',
                'tb_sertifikat.masa_berlaku',
                'tb_sertifikat.nilai',
                'tb_sertifikat.keterangan'
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
            $pdf = PDF::loadView(
                'template_sertifikat.cetak.cetak_sertifikat_potrait',
                compact('data_sertifikat_peserta', 'data_penadatangan', 'templateBg')
            )->setPaper('a4', 'potrait');
        } else {
            $pdf = PDF::loadView(
                'template_sertifikat.cetak.cetak_sertifikat_landscape',
                compact('data_sertifikat_peserta', 'data_penadatangan', 'templateBg')
            )->setPaper('a4', 'landscape');
        }

        return $pdf->download($fileName);
    }

    public function checkSertifikat($part1, $part2, $part3, $part4, $part5)
    {
        $nomor_sertifikat = "$part1/$part2/$part3/$part4/$part5";
        $exist = Sertifikat::where('nomor_sertifikat', $nomor_sertifikat)->exists();

        if ($exist) {
            $data_sertifikat_peserta = DB::table('tb_sertifikat')
                ->join('tb_peserta', 'tb_sertifikat.peserta_id', '=', 'tb_peserta.id_peserta')
                ->join('tb_user', 'tb_peserta.user_id', '=', 'tb_user.id_user')
                ->join('tb_event_skema', 'tb_peserta.event_skema_id', '=', 'tb_event_skema.id_event_skema')
                ->join('tb_event', 'tb_event_skema.event_id', '=', 'tb_event.id_event')
                ->join('tb_jenis_event', 'tb_event.jenis_event_id', '=', 'tb_jenis_event.id_jenis_event')
                ->join('tb_skema', 'tb_event_skema.skema_id', '=', 'tb_skema.id_skema')
                ->join('tb_background', 'tb_event_skema.background_id', '=', 'tb_background.id_background')
                ->select(
                    'tb_user.nama_lengkap',
                    'tb_event_skema.id_event_skema',
                    'tb_event.nama_event',
                    'tb_jenis_event.nama_jenis_event',
                    'tb_skema.nama_skema',
                    'tb_background.nama_bg',
                    'tb_background.orientasi_bg',
                    'tb_background.path_bg',
                    'tb_sertifikat.nomor_sertifikat',
                    'tb_sertifikat.tgl_terbit',
                    'tb_sertifikat.tgl_berakhir',
                    'tb_sertifikat.masa_berlaku',
                    'tb_sertifikat.nilai',
                    'tb_sertifikat.keterangan'
                )
                ->where('tb_sertifikat.nomor_sertifikat', $nomor_sertifikat)
                ->first();

            $url = config('app.url');
            $qrCodeData = $url . '/sertifikat/checkSertifikat/' . $data_sertifikat_peserta->nomor_sertifikat;
            $qrCode = QrCode::format('svg')->size(80)->errorCorrection('H')
                ->generate($qrCodeData);

            if ($data_sertifikat_peserta->orientasi_bg === 'landscape') {
                return view(
                    'template_sertifikat.check.check_sertifikat_landscape',
                    compact('data_sertifikat_peserta', 'qrCode')
                );
            } else {
                return view(
                    'template_sertifikat.check.check_sertifikat_potrait',
                    compact('data_sertifikat_peserta', 'qrCode')
                );
            }

        } else {
            return view('template_sertifikat.check.check_sertifikat_error');
        }

    }

    public function showSertifikat($request_id)
    {
        $id = intval($request_id);

        $data_sertifikat_peserta = DB::table('tb_sertifikat')
            ->join('tb_peserta', 'tb_sertifikat.peserta_id', '=', 'tb_peserta.id_peserta')
            ->join('tb_user', 'tb_peserta.user_id', '=', 'tb_user.id_user')
            ->join('tb_event_skema', 'tb_peserta.event_skema_id', '=', 'tb_event_skema.id_event_skema')
            ->join('tb_event', 'tb_event_skema.event_id', '=', 'tb_event.id_event')
            ->join('tb_jenis_event', 'tb_event.jenis_event_id', '=', 'tb_jenis_event.id_jenis_event')
            ->join('tb_skema', 'tb_event_skema.skema_id', '=', 'tb_skema.id_skema')
            ->join('tb_background', 'tb_event_skema.background_id', '=', 'tb_background.id_background')
            ->select(
                'tb_user.nama_lengkap',
                'tb_event.nama_event',
                'tb_jenis_event.nama_jenis_event',
                'tb_skema.nama_skema',
                'tb_event_skema.id_event_skema',
                'tb_background.nama_bg',
                'tb_background.orientasi_bg',
                'tb_background.path_bg',
                'tb_sertifikat.nomor_sertifikat',
                'tb_sertifikat.tgl_terbit',
                'tb_sertifikat.tgl_berakhir',
                'tb_sertifikat.masa_berlaku',
                'tb_sertifikat.nilai',
                'tb_sertifikat.keterangan'
            )
            ->where('tb_sertifikat.peserta_id', $id)
            ->first();

        $data_penadatangan = DB::table('tb_event_skema')
            ->join('tb_penandatangan', 'tb_event_skema.id_event_skema', '=', 'tb_penandatangan.event_skema_id')
            ->join('tb_ttd', 'tb_penandatangan.ttd_id', '=', 'tb_ttd.id_ttd')
            ->select('tb_ttd.nama_ttd', 'tb_ttd.jabatan', 'tb_ttd.path_ttd')
            ->where('tb_penandatangan.event_skema_id', $data_sertifikat_peserta->id_event_skema)
            ->get();

        $templateBg = (php_uname('s') === 'Linux') ? public_path(str_replace('\\', '/', $data_sertifikat_peserta->path_bg)) : public_path($data_sertifikat_peserta->path_bg);
        $fileName = 'Sertif-' . $data_sertifikat_peserta->nomor_sertifikat . '.pdf';

        $pdf = "";
        if ($data_sertifikat_peserta->orientasi_bg != 'landscape') {
            $pdf = PDF::loadView(
                'template_sertifikat.show.show_sertifikat_potrait',
                compact('data_sertifikat_peserta', 'data_penadatangan', 'templateBg')
            )->setPaper('a4', 'potrait');
        } else {
            $pdf = PDF::loadView(
                'template_sertifikat.show.show_sertifikat_landscape',
                compact('data_sertifikat_peserta', 'data_penadatangan', 'templateBg')
            )->setPaper('a4', 'landscape');
        }

        return $pdf->stream($fileName);
    }

}
