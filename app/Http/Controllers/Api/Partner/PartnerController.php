<?php

namespace App\Http\Controllers\Api\Partner;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {

            $data = Partner::orderBy('nama_partner', 'asc')->get();
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

        $validatedData = $request->validate([
            'page_id' => 'required|exists:tb_page,id_page',
            'nama_partner' => 'required|string|max:100',
            'email_partner' => 'required|email|max:100',
            'telepon_partner' => 'nullable|string|max:20',
            'alamat_partner' => 'nullable|string|max:255',
            'jenis_partner' => 'nullable|string|max:100',
            'tanggal_bergabung' => 'nullable|date',
            'website_partner' => 'nullable|url|max:255',
            'status_partner' => 'required|boolean',
            'logo' => 'required|string|max:255'
        ]);


        $partner = Partner::create($validatedData);


        return response()->json([
            'status' => true,
            'message' => 'Partner created successfully',
            'data' => $partner
        ], 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $data = Partner::findOrFail($id);
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

        $validatedData = $request->validate([
            'page_id' => 'required|exists:tb_page,id_page',
            'nama_partner' => 'nullable|string|max:100',
            'email_partner' => 'nullable|email|max:100',
            'telepon_partner' => 'nullable|string|max:20',
            'alamat_partner' => 'nullable|string|max:255',
            'jenis_partner' => 'nullable|string|max:50',
            'tanggal_bergabung' => 'nullable|date',
            'website_partner' => 'nullable|url|max:255',
            'status_partner' => 'nullable|boolean',
            'logo' => 'nullable|string|max:255',
        ]);


        $partner = Partner::find($id);


        if (!$partner) {
            return response()->json([
                'status' => false,
                'message' => 'Partner not found',
            ], 404);
        }


        $partner->update($validatedData);
        return response()->json([
            'status' => true,
            'message' => 'Partner updated successfully',
            'data' => $partner
        ], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $partner = Partner::find($id);


        if (!$partner) {
            return response()->json([
                'status' => false,
                'message' => 'Partner not found',
            ], 404);
        }


        $partner->delete();


        return response()->json([
            'status' => true,
            'message' => 'Partner deleted successfully',
        ], 200);
    }

}
