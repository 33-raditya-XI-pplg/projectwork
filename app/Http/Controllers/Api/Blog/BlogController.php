<?php

namespace App\Http\Controllers\Api\Blog;


use App\Models\Blog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {

            $data = Blog::get();
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
            'judul' => 'required|string',
            'slug' => 'required|string',
            'body' => 'required|string',
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

        // Create a new BLog record
        $blog = Blog::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'BLog created successfully',
            'data' => $blog
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $data = Blog::findOrFail($id);
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
        $blog = Blog::find($id);

        if (!$blog) {
            return response()->json([
                'status' => false,
                'message' => 'Blog category not found'
            ], 404);
        }

        // Define validation rules
        $rules = [
            'page_id' => 'required|integer|exists:tb_page,id_page', // Assuming there's a blogs table
            'judul' => 'required|string',
            'slug' => 'required|string',
            'body' => 'required|string',
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
        $blog->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'BLog updated successfully',
            'data' => $blog
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $blog = Blog::find($id);

        if (!$blog) {
            return response()->json([
                'status' => false,
                'message' => 'Blog not found'
            ], 404);
        }

        // Delete the record
        $blog->delete();

        return response()->json([
            'status' => true,
            'message' => 'Blog deleted successfully'
        ], 200);
    }
    }

