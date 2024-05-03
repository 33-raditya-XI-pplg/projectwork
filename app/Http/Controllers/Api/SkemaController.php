<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Skema;

class SkemaController extends Controller
{
    public function show()
    {

        $data = Skema::with('skemaSub_Skema')->get()->map(function ($skema) {
            return [
                'id' => $skema->id_skema,
                'nama_skema' => $skema->nama_skema,
                'daftar_sub_skema' => $skema->skemaSub_Skema->pluck('judul_sub')->toArray()
            ];
        });

        return response()->json(['skema' => $data], 200, [], JSON_PRETTY_PRINT);
    }
}
