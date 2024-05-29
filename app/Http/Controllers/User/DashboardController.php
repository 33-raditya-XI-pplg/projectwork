<?php

namespace App\Http\Controllers\User;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function user_index() {
        $banyak_pengguna = DB::table('tb_user')
                        ->where('level', 'pengguna')
                        ->count();

        $banyak_penguji = DB::table('tb_user')
                        ->where('level', 'penguji')
                        ->count();

        $banyak_skema = DB::table('tb_skema')->count();
        $banyak_event = DB::table('tb_event')->count();

        $data_event = Event::where('status', 'Berlangsung')->get();
        
        return view('user.dashboard', compact(
            'banyak_pengguna', 'banyak_penguji', 
            'banyak_skema', 'banyak_event', 
            'data_event'
        ));
    }

    public function admin_index() {
        $banyak_pengguna = DB::table('tb_user')
                        ->where('level', 'pengguna')
                        ->count();

        $banyak_penguji = DB::table('tb_user')
                        ->where('level', 'penguji')
                        ->count();

        $banyak_skema = DB::table('tb_skema')->count();
        $banyak_event = DB::table('tb_event')->count();

        $data_event = Event::where('status', 'Berlangsung')->get();
        
        return view('admin.dashboard', compact(
            'banyak_pengguna', 'banyak_penguji', 
            'banyak_skema', 'banyak_event', 
            'data_event'
        ));
    }
}
