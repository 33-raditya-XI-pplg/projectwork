<?php

namespace App\Http\Controllers\Api\Testimoni;

use App\Models\Testimoni;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class TestimoniController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    try {
        // Mulai query Testimoni
        $data = Testimoni::query();

        // Ambil input 'nama_page' dari request
        $page_nama = $request->input('nama_page');

        // Jika 'nama_page' tidak kosong, tambahkan join dan filter berdasarkan nama Page
        if (!empty($page_nama)) {
            $data = $data->join('tb_page', 'tb_testimoni.page_id', '=', 'tb_page.id_page')
                         ->where('tb_page.nama_page', $page_nama)
                         ->select('tb_testimoni.*'); // Pilih kolom dari tabel Testimoni
        }

        // Eksekusi query dan ambil data
        $data = $data->get();

        // Tambahkan URL untuk setiap testimoni yang memiliki foto
        $data = $data->map(function ($testimoni) {
            if ($testimoni->photo) {
                $testimoni->photo_url = asset('storage/' . $testimoni->photo);
            }
            return $testimoni;
        });

        // Response jika data ditemukan
        return response()->json([
            'status' => true,
            'message' => 'Data ditemukan',
            'data' => $data
        ], 200);
    } catch (\Exception $e) {
        // Response jika terjadi kesalahan
        return response()->json([
            'status' => false,
            'message' => 'Data tidak ditemukan',
            'error' => $e->getMessage()
        ], 500);
    }
}



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'page_id' => 'required|integer',
            'nama' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'tanggal' => 'required|date',
            'rating' => 'required|integer|min:1|max:5',
            'isi_testimoni' => 'required|string',
            'photo' => 'nullable|url', // Validate as URL
            'status_publikasi' => 'required|boolean',
            'created_by' => 'nullable|integer',
            'updated_by' => 'nullable|integer'
        ]);

        // Use the photo URL if provided
        if ($request->has('photo')) {
            $validatedData['photo'] = $request->input('photo');
        }

        // Create a new Testimoni record
        $testimoni = Testimoni::create($validatedData);

        // Return a success response
        return response()->json([
            'status' => true,
            'message' => 'Testimoni created successfully',
            'data' => $testimoni
        ], 201);
    }




    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $data = Testimoni::findOrFail($id);
            if ($data->photo) {
                $data->photo_url = asset('storage/' . $data->photo);
            }
            return response()->json([
                'status' => true,
                'message' => 'Data ditemukan',
                'data' => $data
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'page_id' => 'nullable|integer',
            'nama' => 'nullable|string|max:100',
            'email' => 'nullable|email|max:100',
            'tanggal' => 'nullable|date',
            'rating' => 'nullable|integer|min:1|max:5',
            'isi_testimoni' => 'nullable|string',
            'photo' => 'nullable|url', // Validate as URL
            'status_publikasi' => 'nullable|boolean',
            'created_by' => 'nullable|integer',
            'updated_by' => 'nullable|integer'
        ]);

        // Find the existing Testimoni record
        $testimoni = Testimoni::find($id);

        // Check if the record exists
        if (!$testimoni) {
            return response()->json([
                'status' => false,
                'message' => 'Testimoni not found',
            ], 404);
        }

        // Use the photo URL if provided
        if ($request->has('photo')) {
            $validatedData['photo'] = $request->input('photo');
        }

        // Update the Testimoni record
        $testimoni->update($validatedData);

        // Return a success response
        return response()->json([
            'status' => true,
            'message' => 'Testimoni updated successfully',
            'data' => $testimoni
        ], 200);
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find the existing Testimoni record
        $testimoni = Testimoni::find($id);

        // Check if the record exists
        if (!$testimoni) {
            return response()->json([
                'status' => false,
                'message' => 'Testimoni not found',
            ], 404);
        }

        // Delete the Testimoni record
        $testimoni->delete();

        // Return a success response
        return response()->json([
            'status' => true,
            'message' => 'Testimoni deleted successfully',
        ], 200);
    }

}
