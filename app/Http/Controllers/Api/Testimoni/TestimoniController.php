<?php

namespace App\Http\Controllers\Api\Testimoni;

use App\Http\Controllers\Controller;
use App\Models\Testimoni;
use Illuminate\Http\Request;

class TestimoniController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {

            $data = Testimoni::get();
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
        'nama' => 'required|string|max:100',
        'email' => 'required|email|max:100',
        'tanggal' => 'required|date',
        'rating' => 'required|integer|min:1|max:5', // Assuming rating is between 1 and 5
        'isi_testimoni' => 'required|string',
        'status_publikasi' => 'required|boolean',
        'created_by' => 'nullable|integer',
        'updated_by' => 'nullable|integer'
    ]);

    // Create a new Testimoni record
    $testimoni = Testimoni::create($validatedData);

    // Return a success response
    return response()->json([
        'status' => true,
        'message' => 'Testimoni created successfully',
        'data' => $testimoni
    ], 201);
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $data = Testimoni::findOrFail($id);
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
            'nama' => 'nullable|string|max:100',
            'email' => 'nullable|email|max:100',
            'tanggal' => 'nullable|date',
            'rating' => 'nullable|integer|min:1|max:5', // Assuming rating is between 1 and 5
            'isi_testimoni' => 'nullable|string',
            'status_publikasi' => 'nullable|boolean',
            'created_by' => 'nullable|integer',
            'updated_by' => 'nullable|integer'
        ]);

        // Find the existing Testimoni record
        $testimoni = Testimoni::find($id);

        // Check if the record exists
        if (!$testimoni) {
            return response()->json([
                'status' => false,
                'message' => 'Testimoni not found',
            ], 404);
        }

        // Update the Testimoni record
        $testimoni->update($validatedData);

        // Return a success response
        return response()->json([
            'status' => true,
            'message' => 'Testimoni updated successfully',
            'data' => $testimoni
        ], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find the existing Testimoni record
        $testimoni = Testimoni::find($id);

        // Check if the record exists
        if (!$testimoni) {
            return response()->json([
                'status' => false,
                'message' => 'Testimoni not found',
            ], 404);
        }

        // Delete the Testimoni record
        $testimoni->delete();

        // Return a success response
        return response()->json([
            'status' => true,
            'message' => 'Testimoni deleted successfully',
        ], 200);
    }

}
