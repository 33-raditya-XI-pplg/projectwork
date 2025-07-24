<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        return view('user.event.laporan.laporan-perkembangan' ,
            [
                'title' => 'Laporan Perkembangan',
            ]
        );
    }
}
