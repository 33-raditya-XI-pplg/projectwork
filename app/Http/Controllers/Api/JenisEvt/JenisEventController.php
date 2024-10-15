<?php

namespace App\Http\Controllers\Api\JenisEvt;

use App\Http\Controllers\Controller;
use App\Models\Jenis_Event;
use Illuminate\Http\Request;

class JenisEventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pageId = $request->input('page_id');

        $jenisevt = Jenis_Event::with('pageJenisEvt')
            ->when($pageId, function ($query, $pageId) {
                return $query->whereHas('pageJenisEvt', function ($query) use ($pageId) {
                    $query->where('page_id', $pageId);
                });
            })
            ->get();
        // $jenisevt = Jenis_Event::with('pageJenisEvt')->get();

        if ($jenisevt->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan untuk page_id yang dimasukan.'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data jenis event ditemukan',
            'data' => $jenisevt,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'nama_jenis_event' => 'required|string|max:255',
            'has_lampiran' => 'required|boolean',
            'deskripsi' => 'nullable|string',
            'status' => 'required|string|max:255',
            'page_id' => 'nullable|exists:tb_page,id_page'
        ]);

        $jenisevt = Jenis_Event::create($validateData);

        return response()->json([
            'status' => true,
            'message' => 'Data jenis event berhasil ditambahkan',
            'data' => $jenisevt,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $jenisevt = Jenis_Event::with('pageJenisEvt')->find($id);

        if (!$jenisevt) {
            return response()->json([
                'status' => false,
                'message' => 'Data jenis event tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data jenis event ditemukan',
            'data' => $jenisevt,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $jenisevt = Jenis_Event::find($id);

        if (!$jenisevt) {
            return response()->json([
                'status' => false,
                'message' => 'Data jenis event tidak ditemukan',
            ], 404);
        }

        $validateData = $request->validate([
            'nama_jenis_event' => 'required|string|max:255',
            'has_lampiran' => 'required|boolean',
            'deskripsi' => 'nullable|string',
            'status' => 'required|string|max:255',
            'page_id' => 'nullable|exists:tb_page,id_page'
        ]);

        $jenisevt->update($validateData);

        return response()->json([
            'status' => true,
            'message' => 'Data jenis evet berhasil diperbarui',
            'data' => $jenisevt,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jenisevt = Jenis_Event::find($id);

        if (!$jenisevt) {
            return response()->json([
                'status' => false,
                'message' => 'Data jenis event tidak ditemukan '
            ], 404);
        }
        $jenisevt->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data jenis event berhasil dihapus',
        ], 200);
    }
}
