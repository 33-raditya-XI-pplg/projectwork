<?php

namespace App\Http\Controllers\Api\Page;

use App\Models\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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
            'nama_page' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'pindah_halaman' => 'required|string|max:255',
            'status' => 'nullable|boolean'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $sanitizedDeskripsi = strip_tags($request->deskripsi);

            $page = Page::create([
                'nama_page' => $request->nama_page,
                'deskripsi' => $sanitizedDeskripsi,
                'pindah_halaman' => $request->pindah_halaman,
                'status' => $request->has('status') ? true : false,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Page created successfully',
                'data' => $page
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error occurred: ' . $e->getMessage()
            ], 500);
        }
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
                'message' => 'Page not found'
            ], 404);
        }

        $rules = [
            'nama_page' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'pindah_halaman' => 'required|string|max:255',
            'status' => 'nullable|boolean'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $sanitizedDeskripsi = strip_tags($request->deskripsi);

            // Menggunakan isset untuk mengecek apakah field 'status' ada di request
            $status = $request->has('status') ? $request->input('status') : false;

            $page->update([
                'nama_page' => $request->nama_page,
                'deskripsi' => $sanitizedDeskripsi,
                'pindah_halaman' => $request->pindah_halaman,
                'status' => $status,
                'updated_by' => Auth::id(),
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Page updated successfully',
                'data' => $page
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error occurred: ' . $e->getMessage()
            ], 500);
        }
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

        $messages = [];

        if ($page->partners()->exists()) {
            $messages[] = 'Page ini masih digunakan di halaman Partner.';
        }
        if ($page->pageGaleri()->exists()) {
            $messages[] = 'Page ini masih digunakan di halaman Galeri.';
        }
        if ($page->pageProfil()->exists()) {
            $messages[] = 'Page ini masih digunakan di halaman Profil.';
        }
        if ($page->pageFaq()->exists()) {
            $messages[] = 'Page ini masih digunakan di halaman FAQ.';
        }
        if ($page->pageBlog()->exists()) {
            $messages[] = 'Page ini masih digunakan di halaman Blog.';
        }
        if ($page->profilPerusahaan()->exists()) {
            $messages[] = 'Page ini masih digunakan di halaman Profil Perusahaan.';
        }
        if ($page->sliders()->exists()) {
            $messages[] = 'Page ini masih digunakan di halaman Slider.';
        }
        if ($page->testimoni()->exists()) {
            $messages[] = 'Page ini masih digunakan di halaman Testimoni.';
        }
        if ($page->faqs()->exists()) {
            $messages[] = 'Page ini masih digunakan di halaman FAQ.';
        }

        if (!empty($messages)) {
            $errorMessage = implode(' ', $messages);
            return response()->json([
                'status' => false,
                'message' => $errorMessage
            ], 400);
        }

        try {
            if ($page->pageGaleri()->exists()) {
                $page->pageGaleri()->delete();
            }
            if ($page->profilPerusahaan()->exists()) {
                $page->profilPerusahaan()->delete();
            }
            if ($page->sliders()->exists()) {
                $page->sliders()->delete();
            }
            if ($page->testimoni()->exists()) {
                $page->testimoni()->delete();
            }
            if ($page->faqs()->exists()) {
                $page->faqs()->delete();
            }

            $page->delete();

            return response()->json([
                'status' => true,
                'message' => 'Page deleted successfully'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    }

