<?php

namespace App\Http\Controllers\Api\Background;

use App\Http\Controllers\Controller;
use App\Models\Background;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BackgroundController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $background = Background::with('pageBackground')->get();

        return response()->json([
            'status' => true,
            'message' => 'Data background tidak ditemukan',
            'data' => $background,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'nama_bg' => 'required|string|max:255',
            'orientasi_bg' => 'required|in:potrait,landsacape',
            'path_bg' => 'required',
            'rincian_bg' => 'required|string|max:255',
            'page_id' => 'nullable|exists:tb_page,id_page',
        ]);

        $path = $request->file('path_bg')->store('background', 'public');

        $validateData['path_bg'] = $path;

        $background = Background::create($validateData);

        return response()->json([
            'status' => true,
            'message' => 'Data background berhasil ditambahkan ',
            'data' => $background,
        ], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $background = Background::with('pageBackground')->find($id);

        if (!$background) {
            return response()->json([
                'status' => false,
                'message' => 'Data background tidak ditemukan ',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data background ditemukan',
            'data' => $background,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $background = Background::find($id);

        if (!$background) {
            return response()->json([
                'status' => false,
                'message' => 'Data background tidak ditemukan'
            ], 404);
        }
        $validateData = $request->validate([
            'nama_bg' => 'required|string|max:255',
            'orientasi_bg' => 'required|in:potrait,landsacape',
            'path_bg' => 'required',
            'rincian_bg' => 'required|string|max:255',
            'page_id' => 'nullable|exists:tb_page,id_page',
        ]);

        if ($request->hasFile('path_bg')) {

            if ($background->path_bg) {
                Storage::disk('public')->delete($background->path_bg);
            }
            $path = $request->file('path_bg')->store('background', 'public');
            $validateData['path_bg'] = $path;
        }

        $background->update($validateData);

        return response()->json([
            'status' => true,
            'message' => 'data background berhasil diperbarui',
            'data' => $background,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $background = Background::find($id);

        if (!$background) {
            return response()->json([
                'status' => false,
                'message' => 'data background tidak ditemukan',
            ], 404);
        }

        if ($background->path_bg) {
            Storage::disk('public')->delete($background->path_bg);
        }
        $background->delete();

        return response()->json([
            'status' => true,
            'message' => 'data background berhasil dihapus',
        ], 200);
    }
}
