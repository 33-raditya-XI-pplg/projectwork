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
                'path_icon' => $skema->path_icon,
                'daftar_sub_skema' => $skema->skemaSub_Skema->pluck('judul_sub')->toArray()
            ];
        });

        return response()->json(['skema' => $data], 200, [], JSON_PRETTY_PRINT);
    }
    public function shoow($id)
{
    // $skema = Skema::with('skemaSub_Skema')->findOrFail($id);

    // if (!$skema) {
    //     return response()->json(['message' => 'Skema not found'], 404);
    // }

    // $data = [
    //     'id' => $skema->id_skema,
    //     'nama_skema' => $skema->nama_skema,
    //     'path_icon' => $skema->path_icon,
    //     'daftar_sub_skema' => $skema->skemaSub_Skema->pluck('judul_sub')->toArray()
    // ];

    // return response()->json(['skema' => $data], 200, [], JSON_PRETTY_PRINT);
    try {
        $skema = Skema::with('skemaSub_Skema')->findOrFail($id);

        $data = [
            'id' => $skema->id_skema,
            'nama_skema' => $skema->nama_skema,
            'path_icon' => $skema->path_icon,
            'daftar_sub_skema' => $skema->skemaSub_Skema->pluck('judul_sub')->toArray()
        ];

        return response()->json(['skema' => $data], 200, [], JSON_PRETTY_PRINT);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        // Jika skema dengan ID yang diberikan tidak ditemukan, kembalikan respons error
        return response()->json(['message' => 'Skema not found'], 404);
    }
}

}
