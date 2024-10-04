<?php

namespace App\Http\Controllers\Api\Penguji;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class PengujiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penguji = User::where('level', 'penguji')->with('pageuser')->get();

        return response()->json([
            'status' => true,
            'message' => 'Data jenis event ditemukan',
            'data' => $penguji,
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
        $penguji = User::where('level', 'penguji')->with('pageuser')->find($id);

        if (!$penguji) {
            return response()->json([
                'status' => false,
                'message' => 'Data penguji tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data penguji ditemukan',
            'data' => $penguji,
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
