<?php

namespace App\Http\Controllers\Api\BlogKategori;

use App\Models\BlogKategori;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class BlogKategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {

            $data = BlogKategori::get();
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
        // Define validation rules
        $rules = [
            'blog_id' => 'required|integer|exists:tb_blog,id_blog', // Assuming there's a blogs table
            'kategori_id' => 'required|integer|exists:tb_kategori,id_kategori', // Assuming there's a kategoris table
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

        // Create a new BlogKategori record
        $blogKategori = BlogKategori::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Blog category created successfully',
            'data' => $blogKategori
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $data = BlogKategori::findOrFail($id);
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
    public function update(Request $request, $id)
    {
        // Find the record
        $blogKategori = BlogKategori::find($id);

        if (!$blogKategori) {
            return response()->json([
                'status' => false,
                'message' => 'Blog category not found'
            ], 404);
        }

        // Define validation rules
        $rules = [
            'blog_id' => 'required|integer|exists:tb_blog,id_blog', // Assuming there's a blogs table
            'kategori_id' => 'required|integer|exists:tb_kategori,id_kategori', // Assuming there's a kategoris table
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
        $blogKategori->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Blog category updated successfully',
            'data' => $blogKategori
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Find the record
        $blogKategori = BlogKategori::find($id);

        if (!$blogKategori) {
            return response()->json([
                'status' => false,
                'message' => 'Blog category not found'
            ], 404);
        }

        // Delete the record
        $blogKategori->delete();

        return response()->json([
            'status' => true,
            'message' => 'Blog category deleted successfully'
        ], 200);
    }
}
