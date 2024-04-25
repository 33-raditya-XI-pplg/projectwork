<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\Event;

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

        $data_sub_skema = DB::table('tb_event_skema')
                    // user, sub-skema -- nilai (event_skema),  
                    ->join('tb_event', 'tb_event_skema.event_id', '=', 'tb_event.id_event')
                    ->join('tb_skema', 'tb_event_skema.skema_id', '=', 'tb_skema.id_skema')

                    ->join('tb_sub_skema', 'tb_skema.id_skema', '=', 'tb_sub_skema.skema_id')
                    ->select('tb_sub_skema.id_sub_skema', 'tb_sub_skema.judul_sub')
                    ->where('tb_event_skema.skema_id', $id)
                    ->get();

        $data_peserta = DB::table('tb_daftar_peserta')
                    ->join('tb_user', 'tb_daftar_peserta.user_id', '=', 'tb_user.id_user')
                    ->join('tb_event_skema', 'tb_daftar_peserta.event_skema_id', '=', 'tb_event_skema.id_event_skema')
                    ->select('tb_event_skema.id_event_skema', 'tb_user.id_user', 'tb_user.nama_lengkap')
                    ->where('tb_daftar_peserta.event_skema_id', $data_skema->value('id_event_skema'))
                    ->get();

        $data_nilai = DB::table('tb_daftar_peserta')
                        ->join('tb_user', 'tb_daftar_peserta.user_id', '=', 'tb_user.id_user')
                        ->join('tb_event_skema', 'tb_daftar_peserta.event_skema_id', '=', 'tb_event_skema.id_event_skema')
                        ->join('tb_skema', 'tb_event_skema.skema_id', '=', 'tb_skema.id_skema')

                        ->join('tb_sub_skema', 'tb_skema.id_skema', '=', 'tb_sub_skema.skema_id')
                        ->select('tb_event_skema.id_event_skema', 'tb_user.id_user', 'tb_user.nama_lengkap',
                            'tb_sub_skema.id_sub_skema', 'tb_sub_skema.judul_sub',
                            // Subquery untuk mengecek keberadaan nilai
                            DB::raw('(SELECT EXISTS(
                                SELECT 1 FROM tb_nilai_peserta
                                WHERE tb_nilai_peserta.user_id = tb_user.id_user
                                AND tb_nilai_peserta.sub_skema_id = tb_sub_skema.id_sub_skema
                            )) AS has_nilai')
                        )
                        ->where('tb_daftar_peserta.event_skema_id', $data_skema->value('id_event_skema'))
                        ->orderBy('tb_user.id_user', 'asc')
                        ->get();

        // $data_nilai = DB::table('tb_nilai_peserta')
        //             // user, sub-skema -- nilai (event_skema),  
        //             ->select('tb_nilai_peserta.user_id', 'tb_nilai_peserta.event_skema_id', 'tb_nilai_peserta.sub_skema_id',
        //                      'tb_nilai_peserta.nilai')
        //             ->where('tb_nilai_peserta.event_skema_id', $data_skema->value('id_event_skema'))
        //             ->get();

        return response()->json([
            'data_skema' => $data_skema, 
            'data_sub_skema' => $data_sub_skema, 
            'data_peserta' => $data_peserta,
            'data_nilai' => $data_nilai
        ]);
    }

    public function fetchPesertaData($id) 
    {
        $data = DB::table('tb_user')
                    ->select('tb_user.nama_lengkap')
                    ->where('tb_user.id_user', $id)
                    ->get();

        return response()->json([
            'data_peserta_dos' => $data
        ]);
    }

    public function create()
    {
        return view('admin.penilaian.inputnilai');
    }

    public function storeNilaiData(Request $request)
    {
        // dd($request);

        // $pesertaID = $request->pesertaID;
        // $nilaiSubSkema = $request->nilaiSubSkema;

        // // Logika untuk menyimpan data
        // foreach ($nilaiSubSkema as $subSkemaID => $nilai) {
        //     // Simpan setiap nilai dengan kode untuk menyimpan ke database
            
        // }

        // return response()->json(['message' => 'Data berhasil disimpan']);

        $pesertaID = $request->pesertaID;
        $eventSkemaID = $request->event_skemaID;
        $nilaiSubSkema = $request->nilaiSubSkema;
        $created_by = $request->createdBy;

        // Mulai transaksi database
        DB::beginTransaction();

        try {
            foreach ($nilaiSubSkema as $subSkemaID => $nilai) {
                // Periksa dulu apakah nilai sudah ada
                $nilaiExist = DB::table('tb_nilai_peserta')
                                ->where('user_id', $pesertaID)
                                ->where('sub_skema_id', $subSkemaID)
                                ->where('event_skema_id', $eventSkemaID)
                                ->first();

                if ($nilaiExist) {
                    // Jika nilai sudah ada, update
                    DB::table('tb_nilai_peserta')
                        ->where('user_id', $pesertaID)
                        ->where('sub_skema_id', $subSkemaID)
                        ->where('event_skema_id', $eventSkemaID)
                        ->update(['nilai' => $nilai]);
                } else {
                    // Jika tidak ada, insert baru
                    DB::table('tb_nilai_peserta')->insert([
                        'user_id' => $pesertaID,
                        'sub_skema_id' => $subSkemaID,
                        'event_skema_id' => $eventSkemaID,
                        'nilai' => $nilai,
                        'created_by' => $created_by
                    ]);
                }
            }

            // Jika semua operasi berhasil, commit transaksi
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Nilai berhasil disimpan']);
        } catch (\Exception $e) {
            // Jika terjadi error, rollback transaksi
            DB::rollback();
            return response()->json(['success' => false, 'message' => 'Gagal menyimpan nilai', 'error' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $peserta = User::find($id);

        return response()->json([
            'data_peserta' => $peserta
        ]);
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy()
    {
        
    }

}
