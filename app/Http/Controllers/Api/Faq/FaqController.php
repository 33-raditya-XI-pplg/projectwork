<?php

namespace App\Http\Controllers\Api\Faq;

use App\Models\Faq;
use App\Models\BlogKategori;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    try {
        // Mulai query Blog
        $data = Faq::query();

        // Ambil input 'nama_page' dari request
        $page_nama = $request->input('nama_page');

        // Jika 'page_nama' tidak kosong, tambahkan join dan filter berdasarkan nama Page
        if (!empty($page_nama)) {
            $data = $data->join('tb_page', 'tb_faq.page_id', '=', 'tb_page.id_page')
                         ->where('tb_page.nama_page', $page_nama)
                         ->select('tb_faq.*'); // Pilih kolom dari tabel Blog
        }

        // Eksekusi query dan dapatkan data
        $data = $data->get();

        return response()->json([
            'status' => true,
            'message' => 'Data ditemukan',
            'data' => $data
        ], 200);
    } catch (\Exception $e) {
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
        $rules = [
            'page_id' => 'required|integer|exists:tb_page,id_page', // Assuming there's a blogs table
            'pertanyaan' => 'required|string',
            'jawaban' => 'required|string', // Assuming there's a kategoris table
            'created_by' => 'nullable|integer|exists:users,id', // Assuming there's a users table
            'updated_by' => 'nullable|integer|exists:users,id', // Assuming there's a users table
        ];

        // Validate incoming request
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Create a new Faq record
        $faq = Faq::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Faq created successfully',
            'data' => $faq
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $data = Faq::findOrFail($id);
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
        $faq = Faq::find($id);

        if (!$faq) {
            return response()->json([
                'status' => false,
                'message' => 'faq not found'
            ], 404);
        }

        // Define validation rules
        $rules = [
            'page_id' => 'required|integer|exists:tb_page,id_page', // Assuming there's a blogs table
            'pertanyaan' => 'required|string',
            'jawaban' => 'required|string', // Assuming there's a kategoris table
            'created_by' => 'nullable|integer|exists:users,id', // Assuming there's a users table
            'updated_by' => 'nullable|integer|exists:users,id', // Assuming there's a users table
        ];

        // Validate incoming request
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Update the record
        $faq->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Faq updated successfully',
            'data' => $faq
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $faq = Faq::find($id);

        if (!$faq) {
            return response()->json([
                'status' => false,
                'message' => 'Faq not found'
            ], 404);
        }

        // Delete the record
        $faq->delete();

        return response()->json([
            'status' => true,
            'message' => 'Faq deleted successfully'
        ], 200);
    }
}
