<?php

namespace App\Http\Controllers\Api\Instansi;

use App\Http\Controllers\Controller;
use App\Models\Instansi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InstansiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pageId = $request->input('page_id');

        $instansi = Instansi::with('pageInstansi')
            ->when($pageId, function ($query, $pageId) {
                return $query->whereHas('pageInstansi', function ($query) use ($pageId) {
                    $query->where('page_id', $pageId);
                });
            })
            ->get();

        // $instansi = Instansi::with('pageInstansi')->get();

        if ($instansi->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan untuk page_id yang dimasukan.'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data tempat ditemukan',
            'data' => $instansi
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_instansi' => 'required|string|max:255',
            'nomor_instansi' => 'required|integer',
            'nama_kepala_instansi' => 'required|string|max:255',
            'jabatan_kepala' => 'required|string|max:255',
            'path_logo' => 'required|file|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|string|max:255',
            'alamat' => 'required|string',
            'alamat_kota' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'no_telp' => 'required|number|max:20',
            'page_id' => 'nullable:exists:tb_page,id_page',
            'created_by' => 'nullable|integer',
            'updated_by' => 'nullable|integer',
        ]);

        if ($request->hasFile('path_logo')) {
            $file = $request->file('path_logo');
            $filename = time() . '_' . $file->getClientOriginalName(); // membuat nama file unik
            $path = $file->storeAs('logo_instansi', $filename, 'public'); // menyimpan file di folder 'storage/app/public/logos'

            $validateData['path_logo'] = $path;
        }

        $instansi = Instansi::create($validatedData);

        return response()->json([
            'status' => true,
            'message' => 'Data instansi berhasil ditambahkan',
            'data' => $instansi
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $instansi = Instansi::with('pageInstansi')->find($id);


        if (!$instansi) {
            return response()->json([
                'status' => false,
                'message' => 'Data tempat tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data tempat ditemukan',
            'data' => $instansi,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $instansi = Instansi::find($id);

        if (!$instansi) {
            return response()->json([
                'status' => false,
                'message' => 'Data tempat tidak ditemukan',
            ], 404);
        }

        $validateData = $request->validate([
            'nama_instansi' => 'required|string|max:255',
            'nomor_instansi' => 'required|integer',
            'nama_kepala_instansi' => 'required|string|max:255',
            'jabatan_kepala' => 'required|string|max:255',
            'path_logo' => 'required|file|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|string|max:255',
            'alamat' => 'required|string',
            'alamat_kota' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'no_telp' => 'required|number|max:20',
            'page_id' => 'nullable:exists:tb_page,id_page',
            'created_by' => 'nullable|integer',
            'updated_by' => 'nullable|integer',
        ]);

        if ($request->hasFile('path_logo')) {
            $file = $request->file('path_logo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('logo_instansi', $filename, 'public');

            $validateData['path_logo'] = $path;

            if ($instansi->path_logo) {
                Storage::disk('public')->delete($instansi->path_logo);
            }
        }

        $instansi->update($validateData);


        return response()->json([
            'status' => true,
            'message' => 'Data tempat berhasil diperbarui',
            'data' => $instansi
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $instansi = Instansi::find($id);

        if (!$instansi) {
            return response()->json([
                'status' => true,
                'message' => 'Data tempat tidak ditemukan'
            ], 404);
        }

        $instansi->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data tempat berhasil dihapus',
        ], 200);
    }
}
