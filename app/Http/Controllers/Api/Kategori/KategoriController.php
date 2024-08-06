<?php

namespace App\Http\Controllers\Api\Kategori;

use App\Models\Kategori;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {

            $data = Kategori::get();
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
            'nama_kategori' => 'required|string|', // Assuming there's a blogs table
            'deskripsi' => 'required|string', // Assuming there's a kategoris table
            'created_by' => 'nullable|integer|exists:users,id',
            'updated_by' => 'nullable|integer|exists:users,id',
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

        // Create a new Kategori record
        $Kategori = Kategori::create($request->all());

        return response()->json([
            'status' => true,
            'message' => ' category created successfully',
            'data' => $Kategori
        ], 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $data = Kategori::findOrFail($id);
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
        $Kategori = Kategori::find($id);

        if (!$Kategori) {
            return response()->json([
                'status' => false,
                'message' => ' category not found'
            ], 404);
        }

        // Define validation rules
        $rules = [
            'nama_kategori' => 'required|string|', // Assuming there's a blogs table
            'deskripsi' => 'required|string', // Assuming there's a kategoris table
            'created_by' => 'nullable|integer|exists:users,id',
            'updated_by' => 'nullable|integer|exists:users,id',
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
        $Kategori->update($request->all());

        return response()->json([
            'status' => true,
            'message' => ' category updated successfully',
            'data' => $Kategori
        ], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $Kategori = Kategori::find($id);

        if (!$Kategori) {
            return response()->json([
                'status' => false,
                'message' => 'category not found'
            ], 404);
        }
        $Kategori->delete();

        return response()->json([
            'status' => true,
            'message' => 'category deleted successfully'
        ], 200);
    }
    }
