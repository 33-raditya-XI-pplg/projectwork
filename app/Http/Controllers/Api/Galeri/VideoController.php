<?php

namespace App\Http\Controllers\Api\Galeri;

use App\Models\Galeri;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {

            $data = Galeri::where('kategori', 'video')->orderBy('nama', 'asc')->get();


            return response()->json([
                'status' => true,
                'message' => 'Data ditemukan',
                'data' => $data
            ], 200);
        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat mengambil data',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    try {

        $rules = [
            'page_id' => 'required|integer',
            'nama' => 'required|string|max:255',
            'path_file' => 'required|string|max:255',
            'kategori' => 'required|in:video',
            'deskripsi' => 'nullable|string|max:255',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        // Cek apakah kategori adalah 'video'
        if ($request->kategori !== 'video') {
            return response()->json([
                'status' => false,
                'message' => 'Hanya dapat menyimpan kategori video'
            ], 400);
        }

        $dataGaleri = new Galeri();
        $dataGaleri->page_id = $request->page_id;
        $dataGaleri->nama = $request->nama;
        $dataGaleri->path_file = $request->path_file;
        $dataGaleri->kategori = $request->kategori;
        $dataGaleri->deskripsi = $request->deskripsi;
        $dataGaleri->save();

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil disimpan',
            'data' => $dataGaleri
        ], 201);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Terjadi kesalahan saat menyimpan data',
            'error' => $e->getMessage()
        ], 500);
    }
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {

            $data = Galeri::where('id_galeri', $id)->where('kategori', 'video')->first();
            if ($data) {
                return response()->json([
                    'status' => true,
                    'message' => 'Data ditemukan',
                    'data' => $data
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat mengambil data',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    try {

        $dataGaleri = Galeri::find($id);

        if (empty($dataGaleri)) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }


        $rules = [
            'page_id' => 'required|integer',
            'nama' => 'required|string|max:255',
            'path_file' => 'required|string|max:255',
            'kategori' => 'required|in:partner,klien,gambar,video',
            'deskripsi' => 'nullable|string|max:255',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }


        if ($request->kategori !== 'video') {
            return response()->json([
                'status' => false,
                'message' => 'Hanya dapat memperbarui kategori video'
            ], 400);
        }

        $dataGaleri->page_id = $request->page_id;
        $dataGaleri->nama = $request->nama;
        $dataGaleri->path_file = $request->path_file;
        $dataGaleri->kategori = $request->kategori;
        $dataGaleri->deskripsi = $request->deskripsi;
        $dataGaleri->save();

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil diperbarui',
            'data' => $dataGaleri
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Terjadi kesalahan saat memperbarui data',
            'error' => $e->getMessage()
        ], 500);
    }
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $dataGaleri = Galeri::find($id);

            if (empty($dataGaleri)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            if ($dataGaleri->kategori !== 'video') {
                return response()->json([
                    'status' => false,
                    'message' => 'Hanya dapat menghapus kategori video'
                ], 400);
            }

            $dataGaleri->delete();

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil dihapus'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat menghapus data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
