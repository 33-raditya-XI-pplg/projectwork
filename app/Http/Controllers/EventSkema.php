<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Skema;
use App\Models\Background;
use App\Models\Ttd;
use App\Models\Rentang_Nilai;

class EventSkema extends Controller
{
    public function create() {
        $skema = Skema::get();
        $bg = Background::get();
        $ttd = Ttd::get();
        $rn = Rentang_Nilai::get();
        return view('admin.event.create-skema', compact('skema', 'bg', 'ttd', 'rn'));
    }

    public function show($id) {

        return view('admin.event.rincian-skema');
    }
}
