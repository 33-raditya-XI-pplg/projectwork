<?php

namespace App\Http\Controllers\Api\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class PenggunaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengguna = User::where('level', 'pengguna')->get();

        return response()->json([
            'status' => true,
            'message' => 'Data jenis event ditemukan',
            'data' => $pengguna,
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
        $pengguna = User::where('level', 'pengguna')->find($id);

        if (!$pengguna) {
            return response()->json([
                'status' => false,
                'message' => 'Data Pengguna tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data Pengguna ditemukan',
            'data' => $pengguna,
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
