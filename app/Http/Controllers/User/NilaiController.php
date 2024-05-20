<?php

namespace App\Http\Controllers\User;

use App\Models\Event_Skema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NilaiController extends Controller
{
    public function index()
    {
        $pesertaId = Auth::user()->id_user;
        $data_skema = Event_Skema::join('tb_event', 'tb_event_skema.event_id', '=', 'tb_event.id_event')
                    ->join('tb_skema', 'tb_event_skema.skema_id', '=', 'tb_skema.id_skema')
                    ->join('tb_tempat', 'tb_event.tempat_id', '=', 'tb_tempat.id_tempat')
                    ->join('tb_jenis_event', 'tb_event.jenis_event_id', '=', 'tb_jenis_event.id_jenis_event')
                    ->join('tb_peserta', 'tb_event_skema.id_event_skema', '=', 'tb_peserta.event_skema_id')
                    ->select('tb_event_skema.id_event_skema', 'tb_event.id_event', 'tb_event.nama_event',
                             'tb_event.tgl_mulai', 'tb_event.tgl_berakhir', 'tb_event.status', 
                             'tb_jenis_event.nama_jenis_event', 'tb_skema.nama_skema', 'tb_tempat.nama_tempat')
                    ->where('tb_peserta.user_id', $pesertaId)
                    ->first();

        $eventSkemaId = $data_skema->id_event_skema;
        $data_nilai_peserta = DB::table('tb_peserta')
                            ->join('tb_user', 'tb_peserta.user_id', '=', 'tb_user.id_user')
                            ->join('tb_event_skema', 'tb_peserta.event_skema_id', '=', 'tb_event_skema.id_event_skema')
                            ->join('tb_event', 'tb_event_skema.event_id', '=', 'tb_event.id_event')
                            ->join('tb_skema', 'tb_event_skema.skema_id', '=', 'tb_skema.id_skema')

                            ->leftJoinSub(function ($query) {
                                $query->from('tb_nilai_peserta')
                                    ->select('peserta_id',
                                        DB::raw('COUNT(nilai) as banyak_nilai'),
                                        DB::raw('SUM(CASE WHEN nilai = 0 THEN 1 ELSE 0 END) as banyak_nilai_nol'),
                                        DB::raw('SUM(nilai) as total_nilai'),
                                        // DB::raw('SUM(CASE WHEN nilai != 0 THEN nilai ELSE 0 END) / SUM(CASE WHEN nilai != 0 THEN 1 ELSE 0 END) as avg_nilai'),
                                        DB::raw('ROUND(AVG(nilai)) as avg_nilai') // Pake ini wir
                                    )
                                    ->groupBy('peserta_id');
                            }, 'nilai_stats', function ($join) {
                                $join->on('tb_peserta.id_peserta', '=', 'nilai_stats.peserta_id');
                            })

                            ->leftJoinSub(function ($query) {
                                $query->from('tb_nilai_peserta')
                                    ->select('peserta_id', 
                                        DB::raw('MAX(created_at) as created_at'), 
                                        DB::raw('MAX(updated_at) as updated_at')
                                    )
                                    ->groupBy('peserta_id');
                            }, 'nilai_timestamp', function ($join) {
                                $join->on('nilai_stats.peserta_id', '=', 'nilai_timestamp.peserta_id');
                            })

                            ->leftJoinSub(function ($query) use ($eventSkemaId) {
                                $query->from('tb_rentang_nilai')
                                    ->join('tb_event_skema_rentang_nilai', 'tb_rentang_nilai.id_rentang_nilai', '=', 'tb_event_skema_rentang_nilai.rentang_nilai_id')
                                    ->select('tb_event_skema_rentang_nilai.event_skema_id', 'tb_event_skema_rentang_nilai.rentang_nilai_id', 
                                            'tb_rentang_nilai.keterangan_rentang_nilai', 'tb_rentang_nilai.nama_konversi_nilai', 'tb_rentang_nilai.inisial_rentang_nilai',
                                            'tb_rentang_nilai.rentang_atas', 'tb_rentang_nilai.rentang_bawah',
                                    )
                                    ->where('tb_event_skema_rentang_nilai.event_skema_id', $eventSkemaId);
                            }, 'inisial_nilai', function ($join) {
                                $join->on('nilai_stats.avg_nilai', '>=', 'inisial_nilai.rentang_bawah')
                                    ->on('nilai_stats.avg_nilai', '<=', 'inisial_nilai.rentang_atas');
                            })
                            
                            ->select('tb_event_skema.id_event_skema', 'tb_event.nama_event', 'tb_skema.nama_skema',
                                    'tb_user.id_user', 'tb_peserta.id_peserta', 
                                    'tb_user.nama_lengkap', 'nilai_stats.banyak_nilai', 'nilai_stats.banyak_nilai_nol', 
                                    'nilai_stats.total_nilai', 'nilai_stats.avg_nilai',
                                    'inisial_nilai.keterangan_rentang_nilai', 'inisial_nilai.inisial_rentang_nilai', 'inisial_nilai.nama_konversi_nilai',
                                    'nilai_timestamp.created_at', 'nilai_timestamp.updated_at')
                            ->where('tb_peserta.user_id', $pesertaId)
                            ->get();

                    // dd($data_nilai_peserta);

        return view('user.nilai.index', compact('data_nilai_peserta'));
    }
}
