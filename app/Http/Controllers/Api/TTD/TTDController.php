<?php

namespace App\Http\Controllers\Api\TTD;

use App\Http\Controllers\Controller;
use App\Models\Ttd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TTDController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pageId = $request->input('page_id');

        $ttd = Ttd::with('pagettd', 'ttdInstansi')
            ->when($pageId, function ($query, $pageId) {
                return $query->whereHas('pagettd', function ($query) use ($pageId) {
                    $query->where('page_id', $pageId);
                });
            })
            ->get();

        // $ttd = Ttd::with('pagettd', 'ttdInstansi')->get();
        if ($ttd->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan untuk page_id yang dimasukan.'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'data Ttd ditemukan',
            'data' => $ttd,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'instansi_id' => 'nullable|exists:tb_instansi,id_instansi',
            'page_id' => 'nullable|exists:tb_page,id_page',
            'nama_ttd' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'nomor_induk' => 'required|integer',
            'path_ttd' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|string',
        ]);

        $path = $request->file('path_ttd')->store('ttd', 'publid');
        $validateData['path_ttd'] = $path;

        $ttd = Ttd::create($validateData);

        return response()->json([
            'status' => true,
            'message' => 'Data TTD berhasil ditambahkan',
            'data' => $ttd,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $ttd = Ttd::with('pagettd', 'ttdInstansi')->find($id);

        if (!$ttd) {
            return response()->json([
                'status' => false,
                'message' => 'data TTD tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data TTD ditemukan ',
            'data' => $ttd,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $ttd = Ttd::find($id);

        if (!$ttd) {
            return response()->json([
                'status' => false,
                'message' => 'Data TTD tidak ditemukan',
            ], 404);
        }

        $validateData = $request->validate([
            'instansi_id' => 'nullable|exists:tb_instansi,id_instansi',
            'page_id' => 'nullable|exists:tb_page,id_page',
            'nama_ttd' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'nomor_induk' => 'required|integer',
            'path_ttd' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|string',
        ]);

        if ($request->hasFile('path_ttd')) {
            if ($ttd->path_ttd) {
                Storage::disk('public')->delete($ttd->path_ttd);
            }

            $path = $request->file('path_ttd')->store('ttd', 'public');
            $validateData['path_ttd'] = $path;
        }

        // Memperbarui data TTD di database
        $ttd->update($validateData);

        return response()->json([
            'status' => true,
            'message' => 'Data TTD berhasil diperbarui',
            'data' => $ttd,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ttd = Ttd::find($id);

        if ($ttd) {
            return response()->json([
                'status' => false,
                'message' => 'data TTD tidak ditemukan',
            ], 404);
        }

        if ($ttd->path_ttd) {
            Storage::disk('public')->delete($ttd->path_ttd);
        }

        $ttd->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data TTD berhasil dihapus',
        ], 200);
    }
}
