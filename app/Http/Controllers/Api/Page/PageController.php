<?php

namespace App\Http\Controllers\Api\Page;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {

            $data = Page::get();
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
            'nama_page' => 'required|string', // Assuming there's a blogs table
            'deskripsi' => 'required|string',
            'pindah_halaman' => 'required|string',
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
        $page = Page::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'BLog created successfully',
            'data' => $page
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $data = Page::findOrFail($id);
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
        $page = Page::find($id);

        if (!$page) {
            return response()->json([
                'status' => false,
                'message' => 'Blog category not found'
            ], 404);
        }

        // Define validation rules
        $rules = [
            'nama_page' => 'required|string', // Assuming there's a blogs table
            'deskripsi' => 'required|string',
            'pindah_halaman' => 'required|string',
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
        $page->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Page updated successfully',
            'data' => $page
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $page = Page::find($id);

        if (!$page) {
            return response()->json([
                'status' => false,
                'message' => 'Page not found'
            ], 404);
        }

        // Delete the record
        $page->delete();

        return response()->json([
            'status' => true,
            'message' => 'Page deleted successfully'
        ], 200);
    }

    }

