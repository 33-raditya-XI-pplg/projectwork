<?php

namespace App\Http\Controllers\Api\Rentang;

use App\Http\Controllers\Controller;
use App\Models\Rentang_Nilai;
use Illuminate\Http\Request;

class Rentang_nilaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rentang = Rentang_Nilai::all();

        return response()->json([
            'status' => true,
            'message' => 'Data Rentang nilai ditemukan',
            'data' => $rentang
        ], 200);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'nama_konversi_nilai' => 'required|string|max:255',
            'inisial_rentang_nilai' => 'required|string|max:255',
            'keterangan_rentang_nilai' => 'required|string',
            'rentang_atas' => 'required|integer|max:255',
            'rentang_bawah' => 'required|integer|max:255',
            // 'page_id' => 'nullable:exists:tb_page.id_page',
            'created_by' => 'nullable|integer',
            'updated_by' => 'nullable|integer',
        ]);

        $rentang = Rentang_Nilai::create($validateData);

        return response()->json([
            'status' => true,
            'message' => 'Data Rentang nilai berhasil ditambahkan',
            'data' => $rentang,
        ], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rentang = Rentang_Nilai::find($id);

        if (!$rentang) {
            return response()->json([
                'status' => false,
                'message' => 'Data Rentang nilai tidak ditemukan ',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data Rentang nilai ditemukan',
            'data' => $rentang,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rentang = Rentang_Nilai::find($id);

        if (!$rentang) {
            return response()->json([
                'status' => false,
                'message' => 'Data Rentang nilai tidak ditemukan',
            ], 404);
        }
        $validateData = $request->validate([
            'nama_konversi_nilai' => 'required|string|max:255',
            'inisial_rentang_nilai' => 'required|string|max:255',
            'keterangan_rentang_nilai' => 'required|string',
            'rentang_atas' => 'required|integer|max:255',
            'rentang_bawah' => 'required|integer|max:255',
            // 'page_id' => 'nullable:exists:tb_page.id_page',
            'created_by' => 'nullable|integer',
            'updated_by' => 'nullable|integer',
        ]);

        $rentang->update($validateData);

        return response()->json([
            'status' => true,
            'message' => 'Data Rentang nilai berhasil diperbarui',
            'data' => $rentang,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $rentang = Rentang_Nilai::find($id);

        if (!$rentang) {
            return response()->json([
                'status' => false,
                'message' => 'Data Rentang nilai tidak ditemukan ',
            ], 404);
        }

        $rentang->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data Rentang nilai berhasil dihapus',
        ], 200);
    }
}
