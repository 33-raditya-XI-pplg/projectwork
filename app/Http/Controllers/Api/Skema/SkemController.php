<?php

namespace App\Http\Controllers\Api\Skema;

use App\Http\Controllers\Controller;
use App\Models\Skema;
use Illuminate\Http\Request;

class SkemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $skema = Skema::with('pageskema')->get();

        return response()->json([
            'status' => true,
            'message' => 'Data jenis event ditemukan',
            'data' => $skema,
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
        // Menemukan data jenis event berdasarkan id
        $skema = Skema::with('pageskema')->find($id);

        if (!$skema) {
            return response()->json([
                'status' => false,
                'message' => 'Data jenis event tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data jenis event ditemukan',
            'data' => $skema,
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
