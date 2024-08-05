<?php

namespace App\Http\Controllers\Api\ProfileCompany;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ProfilPerusahaanController;
use Illuminate\Http\Request;
use App\Models\Profil_Perusahaan;

class ProfileCompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {

            $data = Profil_Perusahaan::get();
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
        // Validate the incoming request data
        $validatedData = $request->validate([
            'page_id' => 'required|integer',
            'tentang_kami' => 'required|string',
            'path_struktur_organisasi' => 'required|string|max:255',
            'visi' => 'required|string',
            'misi' => 'required|string',
            'sejarah' => 'required|string',
            'created_by' => 'nullable|integer',
            'updated_by' => 'nullable|integer'
        ]);

        // Create a new CompanyProfile record
        $profile = Profil_Perusahaan::create($validatedData);

        // Return a success response
        return response()->json([
            'status' => true,
            'message' => 'Company profile created successfully',
            'data' => $profile
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $data = Profil_Perusahaan::findOrFail($id);
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
        // Validate the incoming request data
        $validatedData = $request->validate([
            'page_id' => 'nullable|integer',
            'tentang_kami' => 'nullable|string',
            'path_struktur_organisasi' => 'nullable|string|max:255',
            'visi' => 'nullable|string',
            'misi' => 'nullable|string',
            'sejarah' => 'nullable|string',
            'created_by' => 'nullable|integer',
            'updated_by' => 'nullable|integer'
        ]);

        // Find the existing CompanyProfile record
        $profile = Profil_Perusahaan::find($id);

        // Check if the record exists
        if (!$profile) {
            return response()->json([
                'status' => false,
                'message' => 'Company profile not found',
            ], 404);
        }

        // Update the CompanyProfile record
        $profile->update($validatedData);

        // Return a success response
        return response()->json([
            'status' => true,
            'message' => 'Company profile updated successfully',
            'data' => $profile
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find the existing CompanyProfile record
        $profile = Profil_Perusahaan::find($id);

        // Check if the record exists
        if (!$profile) {
            return response()->json([
                'status' => false,
                'message' => 'Company profile not found',
            ], 404);
        }

        // Delete the CompanyProfile record
        $profile->delete();

        // Return a success response
        return response()->json([
            'status' => true,
            'message' => 'Company profile deleted successfully',
        ], 200);
    }

}
