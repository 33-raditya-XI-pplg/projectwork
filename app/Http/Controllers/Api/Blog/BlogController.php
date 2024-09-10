<?php

namespace App\Http\Controllers\Api\Blog;


use App\Models\Blog;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    try {
        // Mulai query Blog
        $data = Blog::query();

        // Ambil input 'nama_page' dari request
        $page_nama = $request->input('nama_page');

        // Jika 'page_nama' tidak kosong, tambahkan join dan filter berdasarkan nama Page
        if (!empty($page_nama)) {
            $data = $data->join('tb_page', 'tb_blog.page_id', '=', 'tb_page.id_page')
                         ->where('tb_page.nama_page', $page_nama)
                         ->select('tb_blog.*'); // Pilih kolom dari tabel Blog
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
        // Validasi input
        $rules = [
            'page_id' => 'required|integer|exists:tb_page,id_page',
            'judul' => 'required|string|max:255',
            'body' => 'required|string',
            'photo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'status' => 'nullable|boolean',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->all();

        // Generate slug dari judul
        $data['slug'] = Str::slug($request->input('judul'));

        // Strip HTML tags dari body
        $data['body'] = strip_tags($request->body);

        // Handle upload gambar
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/photos', $filename);
            $data['photo'] = $filename;
        }

        // Set status
        $data['status'] = $request->has('status') ? $request->status : false;

        // Buat record blog baru
        $blog = Blog::create($data);

        return response()->json([
            'status' => true,
            'message' => 'Blog created successfully',
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
                'message' => 'Blog not found'
            ], 404);
        }

        // Validasi input
        $rules = [
            'page_id' => 'required|integer|exists:tb_page,id_page',
            'judul' => 'required|string|max:255',
            'body' => 'required|string',
            'photo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'status' => 'nullable|boolean',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->all();

        // Generate slug dari judul
        $data['slug'] = Str::slug($request->input('judul'));

        // Strip HTML tags dari body
        $data['body'] = strip_tags($request->body);

        // Handle upload gambar dan hapus gambar lama
        if ($request->hasFile('photo')) {
            if ($blog->photo) {
                Storage::delete('public/photos/' . $blog->photo);
            }

            $file = $request->file('photo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/photos', $filename);
            $data['photo'] = $filename;
        }

        // Set status
        $data['status'] = $request->has('status') ? $request->status : false;

        // Update record blog
        $blog->update($data);

        return response()->json([
            'status' => true,
            'message' => 'Blog updated successfully',
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
