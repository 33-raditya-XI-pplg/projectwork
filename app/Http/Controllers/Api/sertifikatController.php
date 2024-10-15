<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sertifikat;
use Illuminate\Http\Request;

class sertifikatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sertifikat = Sertifikat::all();

        return response()->json([
            'status' => true,
            'message' => 'Data jenis event ditemukan',
            'data' => $sertifikat,
            // 'daftar_sub_skema' => $skema->skemaSub_Skema->pluck('judul_sub')->toArray(),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $sertifikat = Sertifikat::find($id);

        if (!$sertifikat) {
            return response()->json([
                'status' => false,
                'message' => 'Data Sertifikat tidak ditemukan ',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data Sertifikat ditemukan',
            'data' => $sertifikat,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
