<?php

namespace App\Http\Controllers\Api\Tempat;

use App\Http\Controllers\Controller;
use App\Models\Tempat;
use Illuminate\Http\Request;

class TempatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $pageId = $request->input('page_id');

        $tempat = Tempat::with('pageTempat')
            ->whereHas('pageTempat', function ($query) use ($pageId) {
                if ($pageId) {
                    $query->where('page_id', $pageId);
                }
            })
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Data tempat ditemukan',
            'data' => $tempat,
        ], 200);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_tempat' => 'required|string|max:255',
            'page_id' => 'nullable.exists:tb_page,id_page',
            'no_telp' => 'nullable|string|max:20',
            'alamat' => 'required|string',
            'alamat_kota' => 'required|string|max:255',
            'link_maps' => 'required|string|max:255',
        ]);

        $tempat = Tempat::create($validatedData);

        return response()->json([
            'status' => true,
            'message' => 'Data tempat berhasil ditambahkan',
            'data' => $tempat
        ], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tempat = Tempat::with('pageTempat')->find($id);


        if (!$tempat) {
            return response()->json([
                'status' => false,
                'message' => 'Data tempat tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data tempat ditemukan',
            'data' => $tempat,
            'page' => $tempat->page
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $tempat = Tempat::find($id);

        if (!$tempat) {
            return response()->json([
                'status' => false,
                'message' => 'Data tempat tidak ditemukan',
            ], 404);
        }

        $validateData = $request->validate([
            'nama_tempat' => 'required|string|max:255',
            'page_id' => 'nullable.exists:tb_page,id_page',
            'no_telp' => 'nullable|string|max:20',
            'alamat' => 'required|string',
            'alamat_kota' => 'required|string',
            'link_maps' => 'rquired|string',
        ]);

        $tempat->update($validateData);


        return response()->json([
            'status' => true,
            'message' => 'Data tempat berhasil diperbarui',
            'data' => $tempat
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tempat = Tempat::find($id);

        if (!$tempat) {
            return response()->json([
                'status' => true,
                'message' => 'Data tempat tidak ditemukan'
            ], 404);
        }

        $tempat->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data tempat berhasil dihapus',
        ], 200);
    }
}
