<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Skema;

class SkemaController extends Controller
{
    public function index()
    {

        $data = Skema::with('skemaSub_Skema', 'pageskema')->get()->map(function ($skema) {
            return [
                'id' => $skema->id_skema,
                'nama_skema' => $skema->nama_skema,
                'path_icon' => $skema->path_icon,
                'daftar_sub_skema' => $skema->skemaSub_Skema->pluck('judul_sub')->toArray(),
                'page_id' => $skema->pageskema
            ];
        });

        return response()->json(['skema' => $data], 200, [], JSON_PRETTY_PRINT);
    }
    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'nama_skema' => 'required|string|max:255',
            'path_icon' => 'nullable|file|mimes:jpg,jpeg,png,svg|max:2048', // Ensure the file is an image
            'daftar_sub_skema' => 'nullable|array', // Array of sub-skema titles
            'daftar_sub_skema.*' => 'string', // Validate each sub-skema as a string
            'page_id' => 'required|integer|exists:tb_page,id_page', // Foreign key check if page exists
        ]);
        $path_icon = null;
        if ($request->hasFile('path_icon')) {
            // Store the uploaded file in the 'public/icons' directory and get the file path
            $path_icon = $request->file('path_icon')->store('icons', 'public');
        }

        // Create the new Skema
        $skema = Skema::create([
            'nama_skema' => $validatedData['nama_skema'],
            'path_icon' => $path_icon,
            'page_id' => $request->page_id,
        ]);

        // If there are sub-skema, create them
        if (isset($validatedData['daftar_sub_skema'])) {
            foreach ($validatedData['daftar_sub_skema'] as $subSkemaTitle) {
                $skema->skemaSub_Skema()->create([
                    'judul_sub' => $subSkemaTitle,
                ]);
            }
        }
        return response()->json([
            'status' => true,
            'message' => 'Data skema berhasil dibuat',
            'data' => $skema,
        ], 201);
    }
    public function show($id)
    {
        try {
            $skema = Skema::with('skemaSub_Skema', 'pageskema')->findOrFail($id);

            $data = [
                'id' => $skema->id_skema,
                'nama_skema' => $skema->nama_skema,
                'path_icon' => $skema->path_icon,
                'daftar_sub_skema' => $skema->skemaSub_Skema->pluck('judul_sub')->toArray(),
                'page_id' => $skema->pageskema
            ];

            return response()->json(['skema' => $data], 200, [], JSON_PRETTY_PRINT);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

            return response()->json(['message' => 'Skema not found'], 404);
        }
    }
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama_skema' => 'required|string|max:255',
            'path_icon' => 'nullable|file|mimes:jpg,jpeg,png,svg|max:2048',
            'daftar_sub_skema' => 'nullable|array',
            'daftar_sub_skema.*' => 'string',
            'page_id' => 'required|integer|exists:tb_page,id_page',
        ]);


        $skema = Skema::with('skemaSub_Skema')->findOrFail($id);


        if ($request->hasFile('path_icon')) {

            $path_icon = $request->file('path_icon')->store('icons', 'public');

            if ($skema->path_icon) {
                \Storage::disk('public')->delete($skema->path_icon);
            }
            $skema->path_icon = $path_icon;
        }


        $skema->update([
            'nama_skema' => $validatedData['nama_skema'],
            'path_icon' => $skema->path_icon,
            'page_id' => $request->page_id,
        ]);

        if (isset($validatedData['daftar_sub_skema'])) {
            $skema->skemaSub_Skema()->delete();

            foreach ($validatedData['daftar_sub_skema'] as $subSkemaTitle) {
                $skema->skemaSub_Skema()->create([
                    'judul_sub' => $subSkemaTitle,
                ]);
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Data skema berhasil diperbarui',
            'data' => $skema
        ], 200);
    }
    public function destroy($id)
    {
        try {
            $skema = Skema::with('skemaSub_Skema')->findOrFail($id);

            $skema->skemaSub_Skema()->delete();

            if ($skema->path_icon) {
                \Storage::disk('public')->delete($skema->path_icon);
            }
            $skema->delete();

            return response()->json([
                'status' => true,
                'message' => 'Data skema berhasil dihapus',
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Data skema tidak ditemukan'
            ], 404);
        }
    }
}
