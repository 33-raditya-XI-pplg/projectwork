<?php

namespace App\Http\Controllers\Api\Slider;


use App\Models\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {

            $data = Slider::get();
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
    public function store(Request $request): JsonResponse
    {
        // Define validation rules
        $rules = [
            'page_id' => 'required|integer',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image_url' => 'required|string|max:255',
            'position' => 'required|integer',
            'status' => 'required|in:active,inactive',
        ];

        // Validate incoming request
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memasukkan data',
                'errors' => $validator->errors()
            ], 422);
        }

        // Create a new Slider record
        $dataGaleri = new Slider();
        $dataGaleri->page_id = $request->page_id;
        $dataGaleri->title = $request->title;
        $dataGaleri->description = $request->description;
        $dataGaleri->image_url = $request->image_url;
        $dataGaleri->position = $request->position;
        $dataGaleri->status = $request->status;

        $dataGaleri->save();

        return response()->json([
            'status' => true,
            'message' => 'Sukses memasukkan data',
            'data' => $dataGaleri
        ], 201);
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $data = Slider::findOrFail($id);
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
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image_url' => 'nullable|string|max:255',
            'position' => 'nullable|integer',
            'status' => 'nullable|in:active,inactive'
        ]);

        // Find the existing Slider record
        $slider = Slider::find($id);

        // Check if the record exists
        if (!$slider) {
            return response()->json([
                'status' => false,
                'message' => 'Slider not found',
            ], 404);
        }

        // Update the Slider record
        $slider->update($validatedData);

        // Return a success response
        return response()->json([
            'status' => true,
            'message' => 'Slider updated successfully',
            'data' => $slider
        ], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find the existing Slider record
        $slider = Slider::find($id);

        // Check if the record exists
        if (!$slider) {
            return response()->json([
                'status' => false,
                'message' => 'Slider not found',
            ], 404);
        }

        // Delete the Slider record
        $slider->delete();

        // Return a success response
        return response()->json([
            'status' => true,
            'message' => 'Slider deleted successfully',
        ], 200);
    }

    }
