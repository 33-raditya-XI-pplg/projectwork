<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Nilai_Peserta;
use Illuminate\Http\Request;

class PenilaianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Penilaian = Nilai_Peserta::all();

        return response()->json([
            'status' => true,
            'message' => 'Data Penilaian ditemukan',
            'data' => $Penilaian,
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
        $Penilaian = Nilai_Peserta::find($id);

        if (!$Penilaian) {
            return response()->json([
                'status' => false,
                'message' => 'Data Penilaian tidak ditemukan ',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data Penilaian ditemukan',
            'data' => $Penilaian,
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
